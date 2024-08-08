// Select all side menu items in the top section of the sidebar
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

// Add click event listeners to each side menu item
allSideMenu.forEach(item => {
    const li = item.parentElement; // Get the parent <li> element of the <a>

    item.addEventListener('click', function () {
        // Remove 'active' class from all side menu items
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        // Add 'active' class to the clicked side menu item's parent <li>
        li.classList.add('active');
    });
});

// Toggle sidebar visibility when menuBar is clicked
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide'); // Toggle 'hide' class on sidebar
});

// Handle click event on search button in the navigation form
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) { // Check if window width is less than 576px
        e.preventDefault(); // Prevent default form submission behavior
        searchForm.classList.toggle('show'); // Toggle 'show' class on search form
        // Toggle between search and close icons based on form visibility
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});

// Initial setup based on window width
if (window.innerWidth < 768) {
    sidebar.classList.add('hide'); // Hide sidebar if window width is less than 768px
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search'); // Replace close icon with search icon
    searchForm.classList.remove('show'); // Remove 'show' class from search form
}

// Handle resize event to adjust elements based on window width
window.addEventListener('resize', function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search'); // Replace close icon with search icon
        searchForm.classList.remove('show'); // Remove 'show' class from search form
    }
});
