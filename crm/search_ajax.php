<script>
  let selectedCategory = "";

  function fetchRecipes() {
    const search = document.getElementById("searchInput")?.value || '';
    const sort = document.getElementById("sortSelect")?.value || '';

    const params = new URLSearchParams();
    params.append("ajax", "1");
    params.append("search", search);
    params.append("category", selectedCategory);
    params.append("sort", sort);

    fetch("search.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: params.toString()
      })
      .then(res => res.text())
      .then(html => {
        document.getElementById("recipesContainer").innerHTML = html;
      });
  }

  document.querySelectorAll(".category-badge").forEach(badge => {
    badge.addEventListener("click", function() {
      document.querySelectorAll(".category-badge").forEach(b => b.classList.remove("active-filter"));
      this.classList.add("active-filter");

      selectedCategory = this.getAttribute("data-category");
      fetchRecipes();
    });
  });


  document.getElementById("searchInput")?.addEventListener("input", fetchRecipes);
  document.getElementById("sortSelect")?.addEventListener("change", fetchRecipes);

  window.onload = fetchRecipes;
</script>