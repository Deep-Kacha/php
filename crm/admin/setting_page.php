<?php include_once 'navbar.php';
$select = "SELECT * FROM `settings`";
$result = $con->query($select);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Settings</title>
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <script> 
        $(document).ready(function() {
    $("#setting").validate({
            rules: {
                site_title:{
                    required: true,
                },
                site_description:{
                    required: true,
                },
                site_logo: {
                    required: true,
                    url: true,
                },
                rpr: {
                    required: true,
                    number: true,
                    min: 1,
                },
                facebook: {
                    required: true,
                    url: true,
                },
                instagram: {
                    required: true,
                    url: true,
                },
                pinterest: {
                    required: true,
                    url: true,
                },
                youtube: {
                    required: true,
                    url: true,
                }
            },
            messages: {
                site_title:{
                    required: "Please enter site title",
                },
                site_description:{
                    required: "Please enter site description",
                },
                site_logo: {
                    required: "Please enter sit logo URL.",
                    url: "Please enter a valid URL.",
                },
                rpr: {
                    required: "Please enter page number.",
                    number: "Please enter a valid number.",
                    min: "Cooking time must be at least 1 minute.",
                },
                facebook: {
                    required: "Please enter facebook URL.",
                    url: "Please enter a valid URL.",
                },
                instagram: {
                    required: "Please enter instagram URL.",
                    url: "Please enter a valid URL.",
                },
                pinterest: {
                    required: "Please enter pinterest URL.",
                    url: "Please enter a valid URL.",
                },
                youtube: {
                    required: "Please enter youtube URL.",
                    url: "Please enter a valid URL.",
                }
            }
        });
    });
    </script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .error {
        color: red;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 5px;
            border-radius: 4px 4px 0 0;
        }
        .tab.active {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-bottom: none;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #4CAF50;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .toggle-setting {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .toggle-setting:last-child {
            border-bottom: none;
        }
        .toggle-setting-desc {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <h1>Settings</h1>
            </div>
            
            <div class="card">
                <div class="tabs">
                    <div class="tab active">General</div>
                    <div class="tab">Comments</div>
                    <div class="tab">Email</div>
                    <div class="tab">API</div>
                </div>
                
                <h2>General Settings</h2>
                <form id="setting" method="post" action="setting_page.php">
                    <div class="form-group">
                        <label for="site-title">Site Title</label>
                        <input type="text" id="site-title" name="site_title" value="<?php echo $row['site_title'];?>" placeholder="Enter site title">
                    </div>
                    
                    <div class="form-group">
                        <label for="site-description">Site Description</label>
                        <textarea id="site-description" name="site_description" rows="2" placeholder="Enter site description"><?php echo $row['site_about'];?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="site-logo">Site Logo URL</label>
                        <input type="text" id="site-logo" name="site_logo" value="<?php echo $row['site_logo'];?>" placeholder="Enter logo URL">
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="recipes-per-page">Recipes Per Page</label>
                        <input type="number" id="recipes-per-page" name="rpr" value="12" min="1" max="100">
                    </div> -->
                    
                    <h3>Social Media Links</h3>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="text" id="facebook" name="facebook" value="<?php echo $row['facebook_link'];?>" placeholder="Facebook page URL">
                    </div>
                    
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram" value="<?php echo $row['instagram_link'];?>" placeholder="Instagram profile URL">
                    </div>
                    
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="text" id="twitter" name="twitter" value="<?php echo $row['twitter_link'];?>"  placeholder="twitter profile URL">
                    </div>
                    
                    <div class="form-group">
                        <label for="youtube">YouTube</label>
                        <input type="text" id="youtube" name="youtube" value="<?php echo $row['youtube_link'];?>" placeholder="YouTube channel URL">
                    </div>
                    
                    <h3>Display Options</h3>
                    
                    <div class="toggle-setting">
                        <div>
                            <h4>Show Author Names</h4>
                            <div class="toggle-setting-desc">Display recipe authors on recipe cards and detail pages</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="toggle-setting">
                        <div>
                            <h4>Show Cooking Times</h4>
                            <div class="toggle-setting-desc">Display preparation and cooking times on recipe cards</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        $site_name = $_POST['site_title'];
        $site_description = $_POST['site_description'];
        $site_logo = $_POST['site_logo'];
        $youtube = $_POST['youtube'];
        $facebook = $_POST['facebook'];
        $twitter = $_POST['twitter'];
        $instagram = $_POST['instagram'];

        $update = "UPDATE `settings` SET `site_title`='$site_name',`site_about`='$site_description',`site_logo`='$site_logo',`youtube_link`='$youtube',`facebook_link`='$facebook',`twitter_link`='$twitter',`instagram_link`='$instagram' WHERE `sr_no`=1";

        if($con->query($update)){
            alert('success', 'Updated Successfully.');
            redirect("setting_page.php");
        }else{
            alert('alert', 'Failed in update.');
        }


    }


?>