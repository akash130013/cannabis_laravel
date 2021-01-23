$.noConflict();

jQuery( document ).ready( function ( $ ) {

    "use strict";

    [ ].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function ( el ) {
        new SelectFx( el );
    } );

    jQuery( '.selectpicker' ).selectpicker;


    $( '#menuToggle' ).on( 'click', function ( event ) {
        $( 'body' ).toggleClass( 'open' );
    } );

    $( '.search-trigger' ).on( 'click', function ( event ) {
        event.preventDefault();
        event.stopPropagation();
        $( '.search-trigger' ).parent( '.header-left' ).addClass( 'open' );
    } );

    $( '.search-close' ).on( 'click', function ( event ) {
        event.preventDefault();
        event.stopPropagation();
        $( '.search-trigger' ).parent( '.header-left' ).removeClass( 'open' );
    } );

    // $('.user-area> a').on('click', function(event) {
    // 	event.preventDefault();
    // 	event.stopPropagation();
    // 	$('.user-menu').parent().removeClass('open');
    // 	$('.user-menu').parent().toggleClass('open');
    // });

    //Page count change dropdown action
    $( '.dispLimit' ).change( function () {

        var pageUrl = $( '#pageUrl' ).val();
        var limit = $( '.dispLimit' ).find( ":selected" ).val();
        window.location.href = pageUrl + '?limit=' + limit;
    } )
} );


jQuery( '#search_bar' ).keypress( function ( e ) {
    // console.log( e.which );
    if ( e.which === 32 ) {
        e.preventDefault();
        return false;

    }
} );