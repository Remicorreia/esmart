/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
// import './bootstrap';

const $ = require("jquery");
global.$ = global.jQuery = $;
require("bootstrap");

$(() => {

    // Lorsqu'un lien avec la classe "ajax" est cliqué
    $("a.ajax").on("click", (evtClick) => {
      
      // Empêcher le comportement par défaut du lien (redirection vers une autre page)
      evtClick.preventDefault();
  
      // Récupérer l'URL du lien
      var href = evtClick.target.getAttribute("href");
  
      // Envoyer une requête AJAX pour récupérer des données au format JSON à partir de l'URL du lien
      $.ajax({
        url: href,
        data: "qte=" + $("#form{{ produit.id }} [name='qte']").val(),
        dataType: "json",
        success: (data) => {
  
          // Mettre à jour le contenu de l'élément avec l'ID "nombre" avec les données récupérées
          $("#nombre").html(data);
  
          // Afficher les données récupérées dans la console
          alert(data);
        },
        error: (jqXHR, status, error) => {
  
          // Afficher un message d'erreur dans la console en cas d'erreur lors de la requête AJAX
          console.log("ERREUR AJAX", status, error);
        },
      });
    });
  
    // Lorsqu'un formulaire avec l'ID "formRecherche" est soumis
    $("#formRecherche").on("submit", (evtSubmit) => {
  
      // Empêcher le comportement par défaut du formulaire (rechargement de la page)
      evtSubmit.preventDefault();
  
      // Envoyer une requête AJAX pour récupérer du HTML à partir de l'URL du formulaire avec les données du champ de recherche
      $.ajax({
        url: evtSubmit.target.getAttribute("action"),
        data: "search=" + $("#formRecherche #search").val(),
        dataType: "html",
        success: (data) => {
  
          // Mettre à jour le contenu de l'élément avec l'ID "main" avec le HTML récupéré
          $("#main").html(data);
  
          // Afficher le HTML récupéré dans la console
          console.log(data);
        },
        error: (jqXHR, status, error) => {
  
          // Afficher un message d'erreur dans la console en cas d'erreur lors de la requête AJAX
          console.log("ERREUR AJAX", status, error);
        },
      });
    });
  });
  