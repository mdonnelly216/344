
//src = https://www.youtube.com/watch?v=eLgNDpKuGts


async function printPDF() {
    const div = document.getElementById("mechWrapper");

    const canvas = await html2canvas(div, {
        scale: 3,
        useCORS: true,       
        allowTaint: true
    });

    const imgData = canvas.toDataURL("image/png");

    const link = document.createElement('a');
    link.href = imgData;
    link.download = 'mechCard.png';
    link.click();
}