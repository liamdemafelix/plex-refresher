$(function () {
   console.log("jQuery locked and loaded.");

   const selLibrary = $('select[name="library"]');
   const loadingLibraries = $('#loadingLibraries');
   const selItem = $('select[name="item"]');
   const loadingItems = $('#loadingItems');
   const rebuildButton = $('#rebuildButton');
   loadingItems.hide();
   selItem.prop('disabled', true);

   function rebuildLibraries() {
      selLibrary.select2('destroy');
      selLibrary.find('option')
          .remove()
          .end()
          .append('<option value="">Select one</option>')
          .val('')
          .trigger({
             type: 'select2:select',
             params: {
                data: {
                   id: '',
                   text: 'Select one'
                }
             }
          });
      $.ajax({
         url: '/api.php?action=get.libraries',
         method: 'GET',
         cache: false
      }).done((data) => {
         let libraries = [];
         data.data.map((item) => {
            libraries.push({
               id: item.id,
               text: item.text
            });
         });
         selLibrary.select2({
            theme: 'bootstrap4',
            data: libraries
         });
         loadingLibraries.hide();
      }).fail(() => {
         alert('Uh-oh. Something went wrong, please refresh the page. If the problem persists, ping Liam on Discord.');
      });
   }

   selLibrary.select2({
      theme: 'bootstrap4'
   });

   rebuildLibraries();

   selItem.select2({
      theme: 'bootstrap4'
   });

   selLibrary.on('select2:select', function (e) {
      // Load step 2
      loadingItems.show();
      selItem.select2('destroy');
      selItem.find('option')
          .remove()
          .end()
          .append('<option value="">Select one</option>')
          .val('')
          .trigger({
             type: 'select2:select',
             params: {
                data: {
                   id: '',
                   text: 'Select one'
                }
             }
          });
      selItem.prop('disabled', true);

      if (e.params.data.id !== '') {
         $.ajax({
            url: '/api.php?action=get.items&key=' + e.params.data.id,
            method: 'GET',
            cache: false
         }).done((data) => {
            let items = [];
            data.data.map((item) => {
               items.push({
                  id: item.id,
                  text: item.text
               });
            });
            selItem.select2({
               theme: 'bootstrap4',
               data: items
            });
            selItem.prop('disabled', false);
            loadingItems.hide();
         }).fail(() => {
            alert('Uh-oh. Something went wrong, please refresh the page. If the problem persists, ping Liam on Discord.');
         });
      }
   });

   selItem.on('select2:select', function (e) {
      if (e.params.data.id !== "") {
         // We can rebuild
         rebuildButton.removeClass('disabled').prop('disabled', false);
      } else {
         rebuildButton.addClass('disabled').prop('disabled', true);
      }
   });

   rebuildButton.on('click', function () {
      let itemKey = selItem.val();
      selLibrary.prop('disabled', true);
      selItem.prop('disabled', true);
      rebuildButton.addClass('disabled')
          .prop('disabled', true)
          .html('<div class="lds-dual-ring dark"></div> Rebuilding...');
      $.ajax({
         url: '/api.php?action=post.refresh&key=' + itemKey,
         method: 'POST'
      }).done(() => {
         alert('Your request has been sent. New data should appear in Plex within the next couple of minutes.');
      }).fail(() => {
         alert('Uh-oh. The rebuilding process didn\'t work out. Try again. If this persists, ping Liam on Discord.');
      }).always(() => {
         window.location.reload();
      });
   });

});