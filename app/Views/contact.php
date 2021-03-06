<div class="container">
    <div class="row">
        <div class="col">
            <div class="alert alert-success align-center" id="message-alert" <?php if($success){echo 'style="display:block"';} ?>>Message successfully sent!</div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php echo form_open('send_email', ['id'=>'contactForm'])?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Name" value="<?php if(isset($form_values)){echo $form_values['name'];} ?>" required>
                    <p class="invalid"><?php if(isset($validation)&&$validation->hasError('name')){echo $validation->getError('name');}?></p>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="email" placeholder="E-mail" value="<?php if(isset($form_values)){echo $form_values['email'];} ?>" required>
                    <small id="emailHelp" class="form-text">I'll never share your email with anyone else.</small>
                    <?php //echo $validation->email;?>
                    <p class="invalid"><?php if(isset($validation)&&$validation->hasError('email')){echo $validation->getError('email');}?></p>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject" value="<?php if(isset($form_values)){echo $form_values['subject'];} ?>" required>
                    <p class="invalid"><?php if(isset($validation)&&$validation->hasError('subject')){echo $validation->getError('subject');}?></p>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" rows="5" class="form-control" id="message" placeholder="Type your message here." required><?php if(isset($form_values)){echo $form_values['message'];} ?></textarea>
                    <p class="invalid"><?php if(isset($validation)&&$validation->hasError('message')){echo $validation->getError('message');}?></p>
                </div>
                <button id="submitButton" type="submit" class="btn btn-primary g-recaptcha" data-sitekey="6Ldf07AZAAAAAAflQCaJcWgGFCWevCswpIrm0mJN" data-callback='onSubmit' data-action='submit'>Submit</button>
            <p class="invalid"><?php if(isset($validation)&&$validation->hasError('captcha')){echo $validation->getError('captcha');}?></p>
            <?php echo form_close()?>
        </div>
    </div>
</div>
<script>
    function onSubmit(token) {
        document.getElementById("contactForm").submit();
    }
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>