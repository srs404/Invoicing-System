var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#togglePrintBTN').click(function () {
    doc.fromHTML($('#printBody').html(), 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
});