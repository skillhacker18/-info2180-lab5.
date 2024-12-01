document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    
    lookupButton.addEventListener('click', function() {
        console.log('Button clicked'); // Debugging line
        const countryName = document.getElementById('country').value;
        let url = 'world.php';
        if (countryName) {
            url += '?country=' + encodeURIComponent(countryName);
        }

        fetch(url)
            .then(response => response.text())
            .then(data => {
                console.log('Response from PHP:', data); // Log the PHP response
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
});
