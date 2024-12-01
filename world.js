document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookup-cities');

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

    lookupCitiesButton.addEventListener('click', function() {
        console.log('Lookup Cities button clicked'); // Debugging line
        const countryName = document.getElementById('country').value;
        let url = 'world.php';
        if (countryName) {
            url += '?country=' + encodeURIComponent(countryName) + '&lookup=cities';
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


