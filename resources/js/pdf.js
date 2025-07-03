document.addEventListener('DOMContentLoaded', function () {
     document.getElementById('generarPdfBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const campos = [
            { label: "Nombre del proyecto", name: "Nombre" },
            { label: "Propuesta de valor", name: "PropValor" },
            { label: "Introducción", name: "Introduccion" },
            { label: "Justificación", name: "Justificacion" },
            { label: "Descripción", name: "Descripcion" },
            { label: "Objetivos Generales", name: "ObjsGrals" },
            { label: "Objetivos Específicos", name: "ObjsEspec" },
            { label: "Estado del arte", name: "EdoArte" },
            { label: "Fortalezas", name: "Fortalezas" },
            { label: "Oportunidades", name: "Oportunidades" },
            { label: "Debilidades", name: "Debilidades" },
            { label: "Amenazas", name: "Amenazas" },
            { label: "Metodologías", name: "Metodologias" },
            { label: "Costos", name: "Costos" },
            { label: "Resultados", name: "Resultados" },
            { label: "Referencias", name: "Referencias" }
        ];

        let y = 10;

        campos.forEach(campo => {
            const valor = document.querySelector(`[name="${campo.name}"]`).value.trim();
            doc.setFont("helvetica", "bold");
            doc.text(campo.label + ":", 10, y);
            y += 7;

            doc.setFont("helvetica", "normal");
            const lines = doc.splitTextToSize(valor || "Sin contenido", 180);
            doc.text(lines, 10, y);
            y += lines.length * 7;

            if (y > 270) {
                doc.addPage();
                y = 10;
            }
        });

        doc.save("proyecto.pdf");
    });


});
   