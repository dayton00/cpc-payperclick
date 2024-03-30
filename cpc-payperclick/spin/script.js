const spinButton = document.getElementById("spin-button");
const wheel = document.getElementById("wheel");
const resultDiv = document.getElementById("result");

spinButton.addEventListener("click", () => {
    // Simulate wheel spin using CSS animations or JavaScript techniques
    // ...

    // Generate a random winning sector (e.g., using Math.random())
    const winningSector = generateRandomSector();

    // Display the winning sector in the result div
    resultDiv.textContent = `You won: ${winningSector}`;

    // Send an AJAX request to PHP script to insert result into database
    fetch("insert_result.php", {
        method: "POST",
        body: JSON.stringify({ winningSector }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Result inserted successfully");
        } else {
            console.error("Error inserting result:", data.error);
        }
    });
});
