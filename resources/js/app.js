import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
// Formulaire d'ajout d'un secteur
document.getElementById('addSecteurForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch('/secteurs', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Secteur ajouté avec succès!');
            $('#addSecteurModal').modal('hide');
            location.reload(); // Recharger la page pour voir les nouveaux secteurs
        } else {
            alert('Une erreur s\'est produite.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur s\'est produite.');
    });
});

// Suppression du bouton déconnexion en bas
const logoutButtonBottom = document.getElementById('logout-bottom');
if (logoutButtonBottom) {
    logoutButtonBottom.remove();
}

app.mount('#app');
// Initialisation du calendrier dans votre script
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: '/api/calendar-events',
    });
    calendar.render();
});
