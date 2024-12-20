import './bootstrap';

import Alpine from 'alpinejs';
import $ from 'jquery';
import Swal from 'sweetalert2';


window.$ = window.jQuery = $;
window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();

import.meta.glob([
    '../images/**',
]);

$(document).ready(function() {
    const cocktailList = $('#cocktail-list');
    const isAuthenticated = $('meta[name="auth"]').attr('content') === '1';

    function loadCocktails(letter) {
        $.ajax({
            url: '/cocktails',
            type: 'GET',
            data: { s: letter },
            dataType: 'json',
            beforeSend: function(){
                cocktailList.html('<p>Cargando...</p>');
            },
            success: function(data) {
                displayCocktails(data.drinks);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener cócteles:', jqXHR, textStatus, errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al obtener los cócteles.',
                });
            }
        });
    }

    function displayCocktails(cocktails) {
        let html = '';
        if (cocktails) {
            $.each(cocktails, function(index, cocktail) {
                html += `
                    <div class="cocktail border rounded p-4">
                        <h2>${cocktail.strDrink}</h2>
                        <img src="${cocktail.strDrinkThumb}" alt="${cocktail.strDrink}" class="w-full">
                        <p>${cocktail.strInstructions ?? 'Sin instrucciones'}</p>
                        <button class="save-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-id="${cocktail.idDrink}">Guardar</button>
                    </div>
                `;
            });
        } else {
            html = '<p>No se encontraron cócteles para esta letra.</p>';
        }
        cocktailList.html(html);
        addSaveListeners();
    }

    function addSaveListeners() {
        $('.save-button').off('click').on('click', function() {
            const cocktailId = $(this).data('id');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/cocktails/save',
                type: 'POST',
                data: { id: cocktailId, _token: csrfToken },
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al guardar el cóctel:', jqXHR, textStatus, errorThrown);
                    let errorMessage = 'Hubo un error al guardar el cóctel.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMessage = jqXHR.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        });
    }

    isAuthenticated && loadCocktails('A');

    $('.letter-button').click(function() {
        const letter = $(this).data('letter');
        loadCocktails(letter);
    });


    $(document).on('click', '.delete-button', function() {
        const cocktailId = $(this).data('id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este cóctel se eliminará de tus guardados.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/cocktails/delete',
                    type: 'DELETE',
                    data: { id: cocktailId, _token: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        Swal.fire(
                            '¡Eliminado!',
                            data.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error al eliminar el cóctel:', jqXHR, textStatus, errorThrown);
                        let errorMessage = 'Hubo un error al eliminar el cóctel.';
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                });
            }
        });
    });
});
