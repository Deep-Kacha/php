<?php include("assets/navbar.php"); 
// userLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe - Cooking Recipes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <style>
        body {
            color: #333333 !important;
            background-color: #f5f5f5 !important;
            font-weight: 400;
        }

        .error {
            color: red;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-control {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            margin-bottom: 15px;
        }

        .form-select {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            margin-bottom: 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #eb4a36 !important;
            box-shadow: 0 0 0 0.2rem rgba(235, 74, 54, 0.25) !important;
        }

        .submit-btn {
            background-color: #eb4a36 !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 10px 30px !important;
            font-weight: 600;
            transition: all 0.3s ease !important;
        }

        .submit-btn:hover {
            background-color: #d03a2e !important;
        }

        .btn-add-more {
            background-color: #2F820C;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            margin-bottom: 15px;
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 5px 15px;
            margin-left: 10px;
        }

        .category-badge {
            background-color: #f8f9fa;
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            margin: 5px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-badge:hover,
        .category-badge.active {
            background-color: #eb4a36;
            color: white;
        }

        .upload-preview {
            width: 100%;
            height: 300px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .upload-preview img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }

        .upload-preview i {
            font-size: 48px;
            color: #ddd;
        }

        textarea.form-control {
            border-radius: 15px !important;
        }

        .dynamic-field {
            position: relative;
            padding-right: 40px;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Form validation
            $("#recipeForm").validate({
                rules: {
                    recipeName: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    description: {
                        required: true,
                        minlength: 20,
                        maxlength: 1000
                    },
                    prepTime: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    cookTime: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    servings: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    "ingredient[]": {
                        required: true
                    },
                    "step[]": {
                        required: true
                    },
                    recipeImage: {
                        required: true,
                        extension: "png|jpg|jpeg"
                    }
                },
                messages: {
                    recipeName: {
                        required: "Please enter recipe name",
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot exceed 100 characters"
                    },
                    description: {
                        required: "Please enter recipe description",
                        minlength: "Description must be at least 20 characters",
                        maxlength: "Description cannot exceed 1000 characters"
                    },
                    prepTime: {
                        required: "Please enter preparation time",
                        number: "Please enter a valid number",
                        min: "Preparation time must be at least 1 minute"
                    },
                    cookTime: {
                        required: "Please enter cooking time",
                        number: "Please enter a valid number",
                        min: "Cooking time must be at least 1 minute"
                    },
                    servings: {
                        required: "Please enter number of servings",
                        number: "Please enter a valid number",
                        min: "Servings must be at least 1"
                    },
                    "ingredient[]": {
                        required: "Please enter at least one ingredient"
                    },
                    "step[]": {
                        required: "Please enter at least one cooking step"
                    },
                    recipeImage: {
                        required: "Please upload a recipe image",
                        extension: "Only PNG, JPG, or JPEG files are allowed"
                    }
                }
            });

            // Handle course category selection
            $(".course-category-badge").click(function() {
                $(this).toggleClass("active");

                // Update hidden field with selected courses only
                let courses = [];
                $(".course-category-badge.active").each(function() {
                    courses.push($(this).data("value"));
                });
                $("#selectedCourse").val(courses.join(","));
            });

            // Handle cuisine category selection
            $(".cuisine-category-badge").click(function() {
                $(this).toggleClass("active");

                // Update hidden field with selected cuisines only
                let cuisines = [];
                $(".cuisine-category-badge.active").each(function() {
                    cuisines.push($(this).data("value"));
                });
                $("#selectedCuisine").val(cuisines.join(","));
            });


            // Add more ingredients
            $("#addIngredient").click(function() {
                let newRow = `
                    <div class="dynamic-field mb-2">
                        <div class="input-group">
                            <input type="text" name="ingredient[]" class="form-control" placeholder="e.g., 2 cups flour">
                            <button type="button" class="btn btn-remove remove-field"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `;
                $("#ingredientFields").append(newRow);
            });

            // Add more steps
            $("#addStep").click(function() {
                let stepCount = $("#stepFields .dynamic-field").length + 1;
                let newRow = `
                    <div class="dynamic-field mb-2">
                        <div class="input-group">
                            <textarea name="step[]" class="form-control" placeholder="Step ${stepCount}: Describe cooking instruction" rows="2"></textarea>
                            <button type="button" class="btn btn-remove remove-field"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `;
                $("#stepFields").append(newRow);
            });

            // Remove field
            $(document).on("click", ".remove-field", function() {
                $(this).closest(".dynamic-field").remove();

                // Renumber steps
                $("#stepFields .dynamic-field").each(function(index) {
                    let textArea = $(this).find("textarea");
                    let placeholder = textArea.attr("placeholder");
                    placeholder = placeholder.replace(/Step \d+:/, `Step ${index + 1}:`);
                    textArea.attr("placeholder", placeholder);
                });
            });

            // Image preview
            $("#recipeImage").change(function() {
                let file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $("#imagePreview").attr("src", e.target.result).show();
                        $("#uploadIcon").hide();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</head>

<body>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <h2 class="text-center mb-4" style="color: #eb4a36;">Add Your Recipe</h2>
                    <p class="text-center mb-4">Share your culinary masterpiece with our community</p>

                    <form id="recipeForm" method="post" action="add_recipe.php" enctype="multipart/form-data">
                        <!-- Basic Recipe Information -->
                        <div class="section-card">
                            <h4 class="mb-3">Basic Information</h4>

                            <div class="mb-3">
                                <label for="recipeName" class="form-label">Recipe Name</label>
                                <input type="text" class="form-control" id="recipeName" name="recipeName" placeholder="e.g.,Punner Butter Masala">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Briefly describe your recipe"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="prepTime" class="form-label">Preparation Time (minutes)</label>
                                    <input type="number" class="form-control" id="prepTime" name="prepTime" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cookTime" class="form-label">Cooking Time (minutes)</label>
                                    <input type="number" class="form-control" id="cookTime" name="cookTime" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="servings" class="form-label">Servings</label>
                                    <input type="number" class="form-control" id="servings" name="servings" min="1">
                                </div>
                            </div>

                            <div class="row">
                                <h3>Nutrition Information</h3>
                                <div class="col-md-4 mb-3">
                                    <label for="calories" class="form-label">Calories</label>
                                    <input type="number" class="form-control" id="calories" name="calories" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="protein" class="form-label">Protein</label>
                                    <input type="number" class="form-control" id="protein" name="protein" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="carbohydrates" class="form-label">Carbohydrates</label>
                                    <input type="number" class="form-control" id="carbohydrates" name="carbohydrates" min="1">
                                </div>
                            </div>
                        </div>

                        <!-- Recipe Image -->
                        <div class="section-card">
                            <h4 class="mb-3">Recipe Image</h4>
                            <div class="upload-preview" onclick="document.getElementById('recipeImage').click()">
                                <i class="fas fa-camera" id="uploadIcon"></i>
                                <img id="imagePreview" src="#" alt="Recipe preview">
                            </div>
                            <input type="file" class="form-control" id="recipeImage" name="recipeImage" style="display: none;">
                            <button type="button" class="btn submit-btn mb-3" onclick="document.getElementById('recipeImage').click()">
                                <i class="fas fa-upload me-2"></i> Upload Recipe Image
                            </button>
                            <small class="form-text text-muted">Upload a high-quality image of your finished dish (JPG, PNG)</small>
                        </div>

                        <!-- Categories and Tags -->
                        <div class="section-card">
                            <h4 class="mb-3">Categories</h4>
                            <p class="mb-3">Select all that apply:</p>


                            <h4 class="mb-3">Course</h4>
                            <div class="d-flex flex-wrap mb-3">
                                <span class="category-badge course-category-badge" data-value="breakfast">Breakfast</span>
                                <span class="category-badge course-category-badge" data-value="lunch">Lunch</span>
                                <span class="category-badge course-category-badge" data-value="dinner">Dinner</span>
                                <span class="category-badge course-category-badge" data-value="maincourse">Main Course</span>
                                <span class="category-badge course-category-badge" data-value="snacks">Snacks</span>
                                <span class="category-badge course-category-badge" data-value="appetizers">Appetizers</span>
                                <span class="category-badge course-category-badge" data-value="desserts">Desserts</span>
                                <span class="category-badge course-category-badge" data-value="drinks">Drinks</span>
                            </div>
                            <input type="hidden" id="selectedCourse" name="course" value="">

                            <h4 class="mb-3">Cuisine</h4>
                            <div class="d-flex flex-wrap mb-3">
                                <span class="category-badge cuisine-category-badge" data-value="north-indian">North Indian</span>
                                <span class="category-badge cuisine-category-badge" data-value="south-indian">South Indian</span>
                                <span class="category-badge cuisine-category-badge" data-value="street-food">Street Food</span>
                                <span class="category-badge cuisine-category-badge" data-value="punjabi">Punjabi</span>
                                <span class="category-badge cuisine-category-badge" data-value="gujarati">Gujarati</span>
                                <span class="category-badge cuisine-category-badge" data-value="bengali">Bengali</span>
                                <span class="category-badge cuisine-category-badge" data-value="maharashtrian">Maharashtrian</span>
                            </div>
                            <input type="hidden" id="selectedCuisine" name="cuisine" value="">

                            <h4 class="mb-3">Dietary Preferences</h4>
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="vegetarian" name="dietary[]" value="Vegetarian">
                                    <label class="form-check-label" for="vegetarian">Vegetarian</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="vegan" name="dietary[]" value="Vegan">
                                    <label class="form-check-label" for="Vegan">Vegan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="glutenFree" name="dietary[]" value="Gluten Free">
                                    <label class="form-check-label" for="glutenFree">Gluten Free</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dairyFree" name="dietary[]" value="Dairy Free">
                                    <label class="form-check-label" for="dairyFree">Dairy Free</label>
                                </div>
                            </div>
                            <input type="hidden" name="dietary[]" value="">

                        </div>

                        <!-- Ingredients -->
                        <div class="section-card">
                            <h4 class="mb-3">Ingredients</h4>
                            <div id="ingredientFields">
                                <div class="dynamic-field mb-2">
                                    <div class="input-group">
                                        <input type="text" name="ingredient[]" class="form-control" placeholder="e.g., 2 cups flour">
                                    </div>
                                </div>
                                <div class="dynamic-field mb-2">
                                    <div class="input-group">
                                        <input type="text" name="ingredient[]" class="form-control" placeholder="e.g., 1 tsp salt">
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addIngredient" class="btn btn-add-more">
                                <i class="fas fa-plus me-2"></i> Add More Ingredients
                            </button>
                        </div>

                        <!-- Cooking Steps -->
                        <div class="section-card">
                            <h4 class="mb-3">Cooking Instructions</h4>
                            <div id="stepFields">
                                <div class="dynamic-field mb-2">
                                    <div class="input-group">
                                        <textarea name="step[]" class="form-control" placeholder="Step 1: Describe cooking instruction" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="dynamic-field mb-2">
                                    <div class="input-group">
                                        <textarea name="step[]" class="form-control" placeholder="Step 2: Describe cooking instruction" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addStep" class="btn btn-add-more">
                                <i class="fas fa-plus me-2"></i> Add More Steps
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button name="submit_recipe" type="submit" class="btn submit-btn btn-lg">
                                <i class="fas fa-utensils me-2"></i> Submit Recipe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "assets/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$con->begin_transaction();
if (isset($_POST['submit_recipe'])) {
    $uid = $_SESSION['userID'];
    $recipeName = ($_POST['recipeName']);
    $description = $_POST['description'];
    $prepTime = (int) $_POST['prepTime'];
    $cookTime = (int) $_POST['cookTime'];
    $servings = (int) $_POST['servings'];
    $calories = (int) $_POST['calories'];
    $protein = (int) $_POST['protein'];
    $carbohydrates = (int) $_POST['carbohydrates'];
    $recipeImage = uniqid() . "_" . $_FILES['recipeImage']['name'];
    $course = json_encode($_POST['course']);
    $cuisine = json_encode($_POST['cuisine']);
    $diet = json_encode($_POST['dietary']);
    $ingredient = json_encode($_POST['ingredient']);
    $step = json_encode( $_POST['step']);

    try {
        $stmt = $con->prepare("INSERT INTO recipes (user_id, title, description, recipe_image, instructions, ingredients) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $uid, $recipeName, $description, $recipeImage, $step, $ingredient);
        
        if (!$stmt->execute()) {
            throw new Exception("Recipe insert failed: " . $stmt->error);
        }

        // INSERT INTO `recipe_states`(`recipe_states_id`, `recipe_id`, `cooking_time`, `prep_time`, `course`, `diet`, `cuisin`, `calories`, `protein`, `carbohydrates`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
        $recipeid = $con->insert_id;

        $stmt2 = $con->prepare("INSERT INTO recipe_states (recipe_id, cooking_time, prep_time, course, diet, cuisin, calories, protein, carbohydrates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("iiisssiii", $recipeid, $cookTime, $prepTime, $course, $diet, $cuisine, $calories, $protein,  $carbohydrates);

        if (!$stmt2->execute()) {
            throw new Exception("Recipe insert failed: " . $stmt2->error);
        }

        $con->commit();
        move_uploaded_file($_FILES['recipeImage']['tmp_name'], "assets/images/recipes/" . $recipeImage);
        alert("success", "Recipe added successfully.");

    }catch (Exception $e) {
        $con->rollback();
        alert("error", "Something went wrong: " . $e->getMessage());
    }
}



// $recipeQuery = "INSERT INTO recipes (user_id, title, description, recipe_image, instructions, ingredients) VALUES ($uid, '$recipeName', '$description', '$recipeImage', '$step', '$ingredient')";

// $recipe_states = "INSERT INTO `recipe_states`(`recipe_id`, `cooking_time`, `prep_time`, `course`, `diet`, `cuisin`) VALUES ($recipeid, $cookTime, $prepTime, '$course', '$diet', '$cuisine')";


?>