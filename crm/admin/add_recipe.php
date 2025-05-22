<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe <?php echo htmlspecialchars($recipe['title']); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#add_recipe").validate({
                rules: {
                    recipe_name: {
                        required: true,
                    },
                    Category: {
                        required: true,
                    },
                    prepTime: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    cookingTime: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    serving: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    ingred: {
                        required: true,
                    },
                    inst: {
                        required: true,
                    },
                    rimg: {
                        required: true,
                        url: true,
                    }
                },
                messages: {
                    recipe_name: {
                        required: "Please enter valid recipe name",
                    },
                    Category: {
                        required: "Please select the category",
                    },
                    prepTime: {
                        required: "Please enter preparation time.",
                        number: "Please enter a valid number.",
                        min: "Preparation time must be at least 1 minute.",
                    },
                    cookingTime: {
                        required: "Please enter cooking time.",
                        number: "Please enter a valid number.",
                        min: "Cooking time must be at least 1 minute.",
                    },
                    serving: {
                        required: "Please enter number of servings.",
                        number: "Please enter a valid number.",
                        min: "Servings must be at least 1."
                    },
                    ingred: {
                        required: "Please enter the ingredients.",
                    },
                    inst: {
                        required: "Please enter cooking instructions.",
                    },
                    rimg: {
                        required: "Please enter recipe image URL.",
                        url: "Please enter a valid URL.",
                    }
                }
            });
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
    </script>
    <style>
        .form-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        body {
            padding-top: 20px;
            padding-bottom: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center">Add Recipe</h1>
                <p class="text-center text-muted">Make changes to your recipe and save when you're done.</p>
            </div>
        </div>

        <form action="update_recipe.php" id="add_recipe" method="POST">
            <input type="hidden" name="recipe_id" value="1">

            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">Basic Information</h3>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="recipeTitle" class="form-label">Recipe Title</label>
                        <input type="text" class="form-control" id="recipeTitle" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="recipeDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="recipeDescription" name="description" rows="3" required><?php echo htmlspecialchars($recipe['description']); ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="prepTime" class="form-label">Prep Time</label>
                        <input type="text" class="form-control" id="prepTime" name="prep_time" value="<?php echo htmlspecialchars($recipe['prep_time']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cookTime" class="form-label">Cook Time</label>
                        <input type="text" class="form-control" id="cookTime" name="cook_time" value="<?php echo htmlspecialchars($recipe['cook_time']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="totalTime" class="form-label">Total Time</label>
                        <input type="text" class="form-control" id="totalTime" name="total_time" value="<?php echo htmlspecialchars($recipe['total_time']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="course" class="form-label">Course</label>
                        <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($recipe['course']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cuisine" class="form-label">Cuisine</label>
                        <input type="text" class="form-control" id="cuisine" name="cuisine" value="<?php echo htmlspecialchars($recipe['cuisine']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="difficulty" class="form-label">Difficulty</label>
                        <select class="form-select" id="difficulty" name="difficulty" required>
                            <option value="Easy" <?php echo ($recipe['difficulty'] == 'Easy') ? 'selected' : ''; ?>>Easy</option>
                            <option value="Moderate" <?php echo ($recipe['difficulty'] == 'Moderate') ? 'selected' : ''; ?>>Moderate</option>
                            <option value="Hard" <?php echo ($recipe['difficulty'] == 'Hard') ? 'selected' : ''; ?>>Hard</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Nutrition Information -->
            <div class="form-section">
                <h3 class="section-title">Nutrition Information</h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="calories" class="form-label">Calories</label>
                        <input type="text" class="form-control" id="calories" name="calories" value="<?php echo htmlspecialchars($recipe['calories']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="protein" class="form-label">Protein</label>
                        <input type="text" class="form-control" id="protein" name="protein" value="<?php echo htmlspecialchars($recipe['protein']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="carbohydrates" class="form-label">Carbohydrates</label>
                        <input type="text" class="form-control" id="carbohydrates" name="carbohydrates" value="<?php echo htmlspecialchars($recipe['carbohydrates']); ?>">
                    </div>
                </div>
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

            <!-- Instructions -->
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

            <!-- Recipe Image -->
            <div class="form-section">
                <h3 class="section-title">Recipe Image</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Current Image</label>
                        <div class="text-center">
                            <img src="#" alt="Recipe Image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="newImage" class="form-label">Upload New Image</label>
                        <input type="file" class="form-control" id="newImage" name="new_image">
                        <div class="form-text">Leave empty to keep the current image.</div>
                    </div>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg me-2">Save Changes</button>
                <a href="view_recipe.php" class="btn btn-secondary btn-lg">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>