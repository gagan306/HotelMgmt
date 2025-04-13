document.getElementById("bookingForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    const fullName = document.getElementById("fullName").value;
    const email = document.getElementById("email").value;
    const departure = document.getElementById("departure").value;
    const destination = document.getElementById("destination").value;
    const date = document.getElementById("date").value;
    const travelClass = document.getElementById("class").value;

    const resultSection = document.getElementById("resultSection");
    const result = document.getElementById("result");

    result.innerHTML = `
        <strong>Full Name:</strong> ${fullName} <br>
        <strong>Email:</strong> ${email} <br>
        <strong>Departure:</strong> ${departure} <br>
        <strong>Destination:</strong> ${destination} <br>
        <strong>Date:</strong> ${date} <br>
        <strong>Class:</strong> ${travelClass} <br>
        <strong>Status:</strong> Booking Confirmed!
    `;

    resultSection.style.display = "block";
});
