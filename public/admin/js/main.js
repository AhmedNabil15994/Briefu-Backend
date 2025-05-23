
let buttonCommon = {
    exportOptions: {}
};
pdfMake.fonts = {
    Arial: {
            normal: 'arial.ttf',
            bold: 'arialbd.ttf',
            italics: 'ariali.ttf',
            bolditalics: 'arialbi.ttf'
    }
};
let btns = [
            
    $.extend(true, {}, buttonCommon, {

        text: "Page Length",
        className: "btn blue btn-outline",
        extend: 'pageLength'
    }),
    
    $.extend(true, {}, buttonCommon, {

        text: "print",
        className: "btn blue btn-outline",
        extend: 'print',
        exportOptions: {
            columns: 'th:not(.hideInPrint)',
        }
    }),
    
    $.extend(true, {}, buttonCommon, {
        text: "excel",
        className: "btn blue btn-outline",
        extend: 'excelHtml5',
        exportOptions: {
            columns: 'th:not(.hideInPrint)',
        }
    }),
    $.extend(true, {}, buttonCommon, {
        text: "colvis",
        className: "btn blue btn-outline",
        extend: 'colvis'
    }),
];