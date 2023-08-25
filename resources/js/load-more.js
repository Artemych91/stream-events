// public/js/load-more.js

let currentPage = 1; // Current page of events
let lastPage = parseInt(document.querySelector('#events-container').getAttribute('data-last-page'));
let loading = false; // Flag to track loading state

function loadMoreEvents() {
    if (loading || currentPage >= lastPage) {
        return; // Return if already loading or no more pages
    }

    loading = true; // Set loading state

    axios.get(`/?page=${currentPage}`)
        .then(response => {
            const eventsContainer = document.querySelector('#events-container');
            eventsContainer.insertAdjacentHTML('beforeend', response.data); // Append new events

            currentPage++;
            loading = false; // Reset loading state
        })
        .catch(error => {
            console.error(error);
            loading = false; // Reset loading state in case of error
        });
}

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        loadMoreEvents();
    }
});
