import XLSX from 'xlsx';

export function exportToExcel() {
    // Obtén el contenido de tu vista
    const html = document.getElementById('tabla').outerHTML; // ID de tu vista
    // Crea un nuevo libro de Excel
    const wb = XLSX.utils.book_new();
    // Crea una nueva hoja y asigna el contenido de la vista como HTML
    const ws = XLSX.utils.table_to_sheet(html);
    // Agrega la hoja al libro de Excel
    XLSX.utils.book_append_sheet(wb, ws, "Reporte");
    // Guarda el libro de Excel como un archivo .xlsx
    XLSX.writeFile(wb, 'reporte.xlsx');
}
