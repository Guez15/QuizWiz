document.addEventListener("DOMContentLoaded", function() {

        document.querySelectorAll(".vis").forEach(function(button) {
            button.addEventListener("click", function() {
                const url = this.getAttribute("data-filepath");
                window.open(url, '_blank'); //Visualizza il file in una scheda differente
            });
        });

        document.querySelectorAll(".sca").forEach(function(button) {
            button.addEventListener("click", function() {
                const url = this.getAttribute("data-filepath");
                const link = document.createElement('a');
                link.href = url;
                link.download = url.split('/').pop(); // Usa il nome del file dall'URL
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
        });
});
