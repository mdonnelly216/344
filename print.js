
//src = https://www.youtube.com/watch?v=i7EOZB3a1Vs


function printPDF(){
    const{jsPDF} = window.jspdf;
    const doc = new jsPDF();
    doc.text("Hello world!", 10, 10);
    doc.save("test.pdf");
}
