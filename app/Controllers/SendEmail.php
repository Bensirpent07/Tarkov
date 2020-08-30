<?php


namespace App\Controllers;


class SendEmail extends BaseController
{
    public function index($data = array()){
        // Load form helper
        helper('form');

        // Instantiate session
        $session = \Config\Services::session();

        // Set css, javascript, and flashdata
        $data_push = [
            'css' => array('contact.css'),
            'js' => array('contact.js'),
            'success' => $session->get('success')
        ];
        $data = array_merge($data_push, $data);

        // Show views
        echo view('templates/header', $data);
        echo view('contact', $data);
        echo view('templates/footer', $data);
    }
    public function sendEmail(){
        // Instantiate request
        $request = $this->request;

        // Captcha API
        $captchaUser = $request->getPost('g-recaptcha-response');
        // Captcha Key loaded from a file left out of the repo
        $captchaConfig = config('Config\\Credentials');
        $captchaKey = $captchaConfig->captchaKey;
        $captchaOptions = [
            'secret' => $captchaKey,
            'response' => $captchaUser
        ];
        $client = \Config\Services::curlrequest();
        $captchaResponse = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', ['form_params' => $captchaOptions]);
        $captchaObj = json_decode($captchaResponse->getBody());

        // Load validation library
        $validation = \Config\Services::validation();

        // Set validation rules
        $validation->setRules([
            'name' => 'required|alpha_dash|alpha_space',
            'email' => 'required|valid_email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        // Validate inputs
        if (!$this->validate($validation->getRules())){
            // Run index function to show the contact page again
            $data = [
                'validation' => $this->validator,
                'form_values' => [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'subject' => $this->request->getPost('subject'),
                    'message' => $this->request->getPost('message')
                ]
            ];
            $this->index($data);
        }
        // Validate captcha
        elseif(!$validation->check($captchaObj->success, 'required')){
            $validation->setError('captcha','Did not pass captcha. Please try again.');
            // Run index function to show the contact page again
            $data = [
                'validation' => $this->validator,
                'form_values' => [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'subject' => $this->request->getPost('subject'),
                    'message' => $this->request->getPost('message')
                ]
            ];
            $this->index($data);
        }
        else{
            // Set variables to input
            $name = $request->getPost('name');
            $email = $request->getPost('email');
            $subject = $request->getPost('subject');
            $message = $request->getPost('message');

            // Load email class
            $emailC = \Config\Services::email();

            // Set email settings
            $emailC->setFrom('bensirpent07@benkuhman.com', $name);
            $emailC->setReplyTo($email);
            $emailC->setTo('benkuhman@gmail.com');

            $emailC->setSubject($subject);
            $emailC->setMessage($message);

            // Send email
            if($emailC->send(false)){
                // Redirect
                return redirect()->to(base_url().'/contact')->with('success', true);
            }else{
                // Display error
                throw new \CodeIgniter\Database\Exceptions\DatabaseException();
            };
        }
    }
}