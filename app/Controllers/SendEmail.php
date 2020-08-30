<?php


namespace App\Controllers;


class SendEmail extends BaseController
{
    public function index($validation = array()){
        // Load form helper
        helper('form');

        // Instantiate session
        $session = \Config\Services::session();

        // Set css, javascript, and flashdata
        $data = [
            'css' => array('contact.css'),
            'js' => array('contact.js'),
            'val' => $validation,
            'success' => $session->get('success')
        ];

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
            'subject' => 'required|alpha_numeric_punct',
            'message' => 'required|alpha_numeric_punct'
        ]);

        // Validate inputs
        if (!$this->validate($validation->getRules())){
            $this->index($validation->getErrors());
        }
        // Validate captcha
        elseif(!$validation->check($captchaObj->success, 'required')){
            $validation->setError('captcha','Did not pass captcha. Please try again.');
            $this->index($validation->getErrors());
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