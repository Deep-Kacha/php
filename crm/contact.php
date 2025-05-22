<?php include("assets/navbar.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooking Recipes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href = "https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src = "https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>

    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <style>
        /* .contactUs{
            color : white;
            padding : 20px;
            background-color: red;
            border-radius: 20px;
        } */

        .error{
            color : red;
        }

        .form-label{
            font-weight:500;
        }

        .contact-section {
            padding: 60px 0;
        }

        .contact-details p {
            font-size: 1.1rem;
        }

        .contact-input {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            margin-right: 10px;
        }

        .contact-button {
            background-color: #eb4a36 !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 10px 30px !important;
            transition: all 0.3s ease !important;
        }


        .map-container {
            margin-top: 30px;
        }
    </style>

    <script>
        $(document).ready(function(){
            $("#contactForm").validate({
                rules : {
                    name : {
                        required : true,
                        minlength : 2,
                        maxlength : 20,
                    },
                    email : {
                        required : true,
                        email : true,
                    },
                    message : {
                        required : true,
                        minlength : 20,
                        maxlength : 500,
                    }

                },
                messages : {
                    name : {
                        required : "Please enter your name.",
                        minlength : "Please write atleast 2 charachters.",
                        maxlength : "You can only write 20 charachters."
                    },
                    email : {
                        required : "Please enter your email address.",
                        email : "Please enter valid email address."
                    },
                    message : {
                        required : "Please enter Feedback.",
                        minlength : "Please write atleast 20 charachters.",
                        maxlength : "You can only write 500 charachters."
                    }
                }
            });

        });
    </script>
</head>
<body>
<!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <!-- Contact Form Column -->
                <div class="col-md-6">
                    <div class="contactUs">
                        <form action="contact.php" id="contactForm" method="POST">
                            <h2 class="mb-4" style="font-weight:bolder">Hello, what's on your mind?</h2>
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control contact-input" id="name" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control contact-input" id="email" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea class="form-control contact-input" id="message" name="message" rows="5" placeholder="Write your message here" required></textarea>
                            </div>
                            <button type="submit" name="submit-btn" class="btn btn-primary contact-button">Send Message</button>
                        </form>
                    </div>
                </div>

                <!-- Contact Details Column -->
                <div class="col-md-6">
                    <h2 class="mb-4">Get In Touch</h2>
                    <p>If you have any questions or feedback, feel free to reach out to us!</p>

                    <p><strong>Email:</strong> <a href="mailto:contact@cookingrecipes.com">contact@cookingrecipes.com</a></p>
                    <p><strong>Phone:</strong> +1 (123) 456-7890</p>
                    <p><strong>Address:</strong> Rajkot-Bhavnagar Highway, Gadhaka Rd, Tramba, Gujarat 360020</p>

                    <!-- Optional: Embed a Google Map -->
                    <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59083.580404871886!2d70.89556537275391!3d22.25055688786263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959b4a660019ee9%3A0x3d6254f36ed0e794!2sRK%20University%20Main%20Campus!5e0!3m2!1sen!2sin!4v1740151824618!5m2!1sen!2sin" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
</body>
</html>
<?php include("assets/footer.php");


    if(isset($_POST['submit-btn'])){
        if((!(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true))){
            redirect('login.php');
        }else{
            $uid = $_SESSION['userID'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $insert = "INSERT INTO `contact_us`(`user_id`, `name`, `email`, `message`) VALUES (' $uid ','$name','$email','$message')";

            if($con->query($insert)){
                alert("success", "Your message has been sent successfully");
            }else{
                alert("error", "Failed to send message");
            }
        }

    }



?>