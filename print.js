
//src = https://www.youtube.com/watch?v=i7EOZB3a1Vs


async function printPDF() {
    const { jsPDF } = window.jspdf;

    const mechImage = document.getElementById("mechDisplay");

    // Convert image -> canvas
    const canvas = await html2canvas(mechImage, {
        backgroundColor: null, 
        scale: 1 
    });

    const imgData = canvas.toDataURL("image/png");

    const pdf = new jsPDF({
        orientation: canvas.width > canvas.height ? 'landscape' : 'portrait',
        unit: "pt",
        format: [canvas.width, canvas.height],
    });


    pdf.addImage(imgData, "PNG", 0, 0, canvas.width, canvas.height);
    pdf.save("loadout.pdf");
}   