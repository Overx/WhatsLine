/*!
 * 
 * Angle - Bootstrap Admin App + jQuery
 * 
 * Author: @themicon_co
 * Website: http://themicon.co
 * License: http://support.wrapbootstrap.com/knowledge_base/topics/usage-licenses
 * 
 */




(function(window, document, $, undefined){

  if (typeof $ === 'undefined') { throw new Error('This application\'s JavaScript requires jQuery'); }

  $(function(){

    // Restore body classes
    // ----------------------------------- 
    var $body = $('body');
    new StateToggler().restoreState( $body );
    
    // enable settings toggle after restore
    $('#chk-fixed').prop('checked', $body.hasClass('layout-fixed') );
    $('#chk-collapsed').prop('checked', $body.hasClass('aside-collapsed') );
    $('#chk-boxed').prop('checked', $body.hasClass('layout-boxed') );


  }); // doc ready


})(window, document, window.jQuery);

// Start Bootstrap JS
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    // POPOVER
    // ----------------------------------- 

    $('[data-toggle="popover"]').popover();

    // TOOLTIP
    // ----------------------------------- 

    $('[data-toggle="tooltip"]').tooltip({
      container: 'body'
    });

    // DROPDOWN INPUTS
    // ----------------------------------- 
    $('.dropdown input').on('click focus', function(event){
      event.stopPropagation();
    });

  });

})(window, document, window.jQuery);

// Custom jQuery
// ----------------------------------- 








// CLASSYLOADER
// ----------------------------------- 

(function(window, document, $, undefined){
/*
  $(function(){

    var $scroller       = $(window),
        inViewFlagClass = 'js-is-in-view'; // a classname to detect when a chart has been triggered after scroll

    $('[data-classyloader]').each(initClassyLoader);
    
    function initClassyLoader() {
    
      var $element = $(this),
          options  = $element.data();
      
      // At lease we need a data-percentage attribute
      if(options) {
        if( options.triggerInView ) {

          $scroller.scroll(function() {
            checkLoaderInVIew($element, options);
          });
          // if the element starts already in view
          checkLoaderInVIew($element, options);
        }
        else
          startLoader($element, options);
      }
    }

    function checkLoaderInVIew(element, options) {
      var offset = -20;
      if( ! element.hasClass(inViewFlagClass) &&
          $.Utils.isInView(element, {topoffset: offset}) ) {
        startLoader(element, options);
      }
    }
    
    function startLoader(element, options) {
      element.ClassyLoader(options).addClass(inViewFlagClass);
    }

  });
  */

})(window, document, window.jQuery);

/**=========================================================
 * Module: clear-storage.js
 * Removes a key from the browser storage via element click
 =========================================================*/

(function($, window, document){
  'use strict';

  var Selector = '[data-reset-key]';

  $(document).on('click', Selector, function (e) {
      e.preventDefault();
      var key = $(this).data('resetKey');
      
      if(key) {
        $.localStorage.remove(key);
        // reload the page
        window.location.reload();
      }
      else {
        $.error('No storage key specified for reset.');
      }
  });

}(jQuery, window, document));

// GLOBAL CONSTANTS
// ----------------------------------- 


(function(window, document, $, undefined){

  window.APP_COLORS = {
    'primary':                '#5d9cec',
    'success':                '#27c24c',
    'info':                   '#23b7e5',
    'warning':                '#ff902b',
    'danger':                 '#f05050',
    'inverse':                '#131e26',
    'green':                  '#37bc9b',
    'pink':                   '#f532e5',
    'purple':                 '#7266ba',
    'dark':                   '#3a3f51',
    'yellow':                 '#fad732',
    'gray-darker':            '#232735',
    'gray-dark':              '#3a3f51',
    'gray':                   '#dde6e9',
    'gray-light':             '#e4eaec',
    'gray-lighter':           '#edf1f2'
  };
  
  window.APP_MEDIAQUERY = {
    'desktopLG':             1200,
    'desktop':                992,
    'tablet':                 768,
    'mobile':                 480
  };

})(window, document, window.jQuery);


// MARKDOWN DOCS
// ----------------------------------- 
/*

(function(window, document, $, undefined){

  $(function(){

    $('.flatdoc').each(function(){

      Flatdoc.run({
        
        fetcher: Flatdoc.file('documentation/readme.md'),

        // Setup custom element selectors (markup validates)
        root:    '.flatdoc',
        menu:    '.flatdoc-menu',
        title:   '.flatdoc-title',
        content: '.flatdoc-content'

      });

    });


  });

})(window, document, window.jQuery);
*/

// FULLSCREEN
// ----------------------------------- 

(function(window, document, $, undefined){

  if ( typeof screenfull === 'undefined' ) return;

  $(function(){

    var $doc = $(document);
    var $fsToggler = $('[data-toggle-fullscreen]');

    if ( ! $fsToggler.is(':visible') ) // hidden on mobiles
      return;

    $fsToggler.on('click', function (e) {
        e.preventDefault();

        if (screenfull.enabled) {
          
          screenfull.toggle();
          
          // Switch icon indicator
          toggleFSIcon( $fsToggler );

        } else {
          console.log('Fullscreen not enabled');
        }
    });

    if ( screenfull.raw && screenfull.raw.fullscreenchange)
      $doc.on(screenfull.raw.fullscreenchange, function () {
          toggleFSIcon($fsToggler);
      });

    function toggleFSIcon($element) {
      if(screenfull.isFullscreen)
        $element.children('em').removeClass('fa-expand').addClass('fa-compress');
      else
        $element.children('em').removeClass('fa-compress').addClass('fa-expand');
    }

  });

})(window, document, window.jQuery);

/**=========================================================
 * Module: gmap.js
 * Init Google Map plugin
 =========================================================*/

(function($, window, document){
  'use strict';

  // -------------------------
  // Map Style definition
  // -------------------------

  // Custom core styles
  // Get more styles from http://snazzymaps.com/style/29/light-monochrome
  // - Just replace and assign to 'MapStyles' the new style array
  var MapStyles = [{featureType:'water',stylers:[{visibility:'on'},{color:'#bdd1f9'}]},{featureType:'all',elementType:'labels.text.fill',stylers:[{color:'#334165'}]},{featureType:'landscape',stylers:[{color:'#e9ebf1'}]},{featureType:'road.highway',elementType:'geometry',stylers:[{color:'#c5c6c6'}]},{featureType:'road.arterial',elementType:'geometry',stylers:[{color:'#fff'}]},{featureType:'road.local',elementType:'geometry',stylers:[{color:'#fff'}]},{featureType:'transit',elementType:'geometry',stylers:[{color:'#d8dbe0'}]},{featureType:'poi',elementType:'geometry',stylers:[{color:'#cfd5e0'}]},{featureType:'administrative',stylers:[{visibility:'on'},{lightness:33}]},{featureType:'poi.park',elementType:'labels',stylers:[{visibility:'on'},{lightness:20}]},{featureType:'road',stylers:[{color:'#d8dbe0',lightness:20}]}];


  // -------------------------
  // Custom Script
  // -------------------------

  var mapSelector = '[data-gmap]';

  if($.fn.gMap) {
      var gMapRefs = [];
      
      $(mapSelector).each(function(){
          
          var $this   = $(this),
              addresses = $this.data('address') && $this.data('address').split(';'),
              titles    = $this.data('title') && $this.data('title').split(';'),
              zoom      = $this.data('zoom') || 14,
              maptype   = $this.data('maptype') || 'ROADMAP', // or 'TERRAIN'
              markers   = [];

          if(addresses) {
            for(var a in addresses)  {
                if(typeof addresses[a] == 'string') {
                    markers.push({
                        address:  addresses[a],
                        html:     (titles && titles[a]) || '',
                        popup:    true   /* Always popup */
                      });
                }
            }

            var options = {
                controls: {
                       panControl:         true,
                       zoomControl:        true,
                       mapTypeControl:     true,
                       scaleControl:       true,
                       streetViewControl:  true,
                       overviewMapControl: true
                   },
                scrollwheel: false,
                maptype: maptype,
                markers: markers,
                zoom: zoom
                // More options https://github.com/marioestrada/jQuery-gMap
            };

            var gMap = $this.gMap(options);

            var ref = gMap.data('gMap.reference');
            // save in the map references list
            gMapRefs.push(ref);

            // set the styles
            if($this.data('styled') !== undefined) {
              
              ref.setOptions({
                styles: MapStyles
              });

            }
          }

      }); //each
  }

}(jQuery, window, document));

// LOAD CUSTOM CSS
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    $('[data-load-css]').on('click', function (e) {
        
      var element = $(this);

      if(element.is('a'))
        e.preventDefault();
      
      var uri = element.data('loadCss'),
          link;

      if(uri) {
        link = createLink(uri);
        if ( !link ) {
          $.error('Error creating stylesheet link element.');
        }
      }
      else {
        $.error('No stylesheet location defined.');
      }

    });
  });

  function createLink(uri) {
    var linkId = 'autoloaded-stylesheet',
        oldLink = $('#'+linkId).attr('id', linkId + '-old');

    $('head').append($('<link/>').attr({
      'id':   linkId,
      'rel':  'stylesheet',
      'href': uri
    }));

    if( oldLink.length ) {
      oldLink.remove();
    }

    return $('#'+linkId);
  }


})(window, document, window.jQuery);


// JVECTOR MAP 
// ----------------------------------- 

(function(window, document, $, undefined){

  window.defaultColors = {
      markerColor:  '#23b7e5',      // the marker points
      bgColor:      'transparent',      // the background
      scaleColors:  ['#878c9a'],    // the color of the region in the serie
      regionFill:   '#bbbec6'       // the base region color
  };

  window.VectorMap = function(element, seriesData, markersData) {
    
    if ( ! element || !element.length) return;

    var attrs       = element.data(),
        mapHeight   = attrs.height || '300',
        options     = {
          markerColor:  attrs.markerColor  || defaultColors.markerColor,
          bgColor:      attrs.bgColor      || defaultColors.bgColor,
          scale:        attrs.scale        || 1,
          scaleColors:  attrs.scaleColors  || defaultColors.scaleColors,
          regionFill:   attrs.regionFill   || defaultColors.regionFill,
          mapName:      attrs.mapName      || 'world_mill_en'
        };
    
    element.css('height', mapHeight);
    
    init( element , options, seriesData, markersData);
    
    function init($element, opts, series, markers) {
        
        $element.vectorMap({
          map:             opts.mapName,
          backgroundColor: opts.bgColor,
          zoomMin:         1,
          zoomMax:         8,
          zoomOnScroll:    false,
          regionStyle: {
            initial: {
              'fill':           opts.regionFill,
              'fill-opacity':   1,
              'stroke':         'none',
              'stroke-width':   1.5,
              'stroke-opacity': 1
            },
            hover: {
              'fill-opacity': 0.8
            },
            selected: {
              fill: 'blue'
            },
            selectedHover: {
            }
          },
          focusOn:{ x:0.4, y:0.6, scale: opts.scale},
          markerStyle: {
            initial: {
              fill: opts.markerColor,
              stroke: opts.markerColor
            }
          },
          onRegionLabelShow: function(e, el, code) {
            if ( series && series[code] )
              el.html(el.html() + ': ' + series[code] + ' visitors');
          },
          markers: markers,
          series: {
              regions: [{
                  values: series,
                  scale: opts.scaleColors,
                  normalizeFunction: 'polynomial'
              }]
          },
        });

      }// end init
  };

})(window, document, window.jQuery);

// NAVBAR SEARCH
// ----------------------------------- 


(function(window, document, $, undefined){

  $(function(){
    
    var navSearch = new navbarSearchInput();
    
    // Open search input 
    var $searchOpen = $('[data-search-open]');

    $searchOpen
      .on('click', function (e) { e.stopPropagation(); })
      .on('click', navSearch.toggle);

    // Close search input
    var $searchDismiss = $('[data-search-dismiss]');
    var inputSelector = '.navbar-form input[type="text"]';

    $(inputSelector)
      .on('click', function (e) { e.stopPropagation(); })
      .on('keyup', function(e) {
        if (e.keyCode == 27) // ESC
          navSearch.dismiss();
      });
      
    // click anywhere closes the search
    $(document).on('click', navSearch.dismiss);
    // dismissable options
    $searchDismiss
      .on('click', function (e) { e.stopPropagation(); })
      .on('click', navSearch.dismiss);

  });

  var navbarSearchInput = function() {
    var navbarFormSelector = 'form.navbar-form';
    return {
      toggle: function() {
        
        var navbarForm = $(navbarFormSelector);

        navbarForm.toggleClass('open');
        
        var isOpen = navbarForm.hasClass('open');
        
        navbarForm.find('input')[isOpen ? 'focus' : 'blur']();

      },

      dismiss: function() {
        $(navbarFormSelector)
          .removeClass('open')      // Close control
          .find('input[type="text"]').blur() // remove focus
          .val('')                    // Empty input
          ;
      }
    };

  }

})(window, document, window.jQuery);
/**=========================================================
 * Module: notify.js
 * Create toggleable notifications that fade out automatically.
 * Based on Notify addon from UIKit (http://getuikit.com/docs/addons_notify.html)
 * [data-toggle="notify"]
 * [data-options="options in json format" ]
 =========================================================*/

(function($, window, document){
  'use strict';

  var Selector = '[data-notify]',
      autoloadSelector = '[data-onload]',
      doc = $(document);


  $(function() {

    $(Selector).each(function(){

      var $this  = $(this),
          onload = $this.data('onload');

      if(onload !== undefined) {
        setTimeout(function(){
          notifyNow($this);
        }, 800);
      }

      $this.on('click', function (e) {
        e.preventDefault();
        notifyNow($this);
      });

    });

  });

  function notifyNow($element) {
      var message = $element.data('message'),
          options = $element.data('options');

      if(!message)
        $.error('Notify: No message specified');
     
      $.notify(message, options || {});
  }


}(jQuery, window, document));


/**
 * Notify Addon definition as jQuery plugin
 * Adapted version to work with Bootstrap classes
 * More information http://getuikit.com/docs/addons_notify.html
 */

(function($, window, document){

    var containers = {},
        messages   = {},

        notify     =  function(options){

            if ($.type(options) == 'string') {
                options = { message: options };
            }

            if (arguments[1]) {
                options = $.extend(options, $.type(arguments[1]) == 'string' ? {status:arguments[1]} : arguments[1]);
            }

            return (new Message(options)).show();
        },
        closeAll  = function(group, instantly){
            if(group) {
                for(var id in messages) { if(group===messages[id].group) messages[id].close(instantly); }
            } else {
                for(var id in messages) { messages[id].close(instantly); }
            }
        };

    var Message = function(options){

        var $this = this;

        this.options = $.extend({}, Message.defaults, options);

        this.uuid    = "ID"+(new Date().getTime())+"RAND"+(Math.ceil(Math.random() * 100000));
        this.element = $([
            // alert-dismissable enables bs close icon
            '<div class="uk-notify-message alert-dismissable">',
                '<a class="close">&times;</a>',
                '<div>'+this.options.message+'</div>',
            '</div>'

        ].join('')).data("notifyMessage", this);

        // status
        if (this.options.status) {
            this.element.addClass('alert alert-'+this.options.status);
            this.currentstatus = this.options.status;
        }

        this.group = this.options.group;

        messages[this.uuid] = this;

        if(!containers[this.options.pos]) {
            containers[this.options.pos] = $('<div class="uk-notify uk-notify-'+this.options.pos+'"></div>').appendTo('body').on("click", ".uk-notify-message", function(){
                $(this).data("notifyMessage").close();
            });
        }
    };


    $.extend(Message.prototype, {

        uuid: false,
        element: false,
        timout: false,
        currentstatus: "",
        group: false,

        show: function() {

            if (this.element.is(":visible")) return;

            var $this = this;

            containers[this.options.pos].show().prepend(this.element);

            var marginbottom = parseInt(this.element.css("margin-bottom"), 10);

            this.element.css({"opacity":0, "margin-top": -1*this.element.outerHeight(), "margin-bottom":0}).animate({"opacity":1, "margin-top": 0, "margin-bottom":marginbottom}, function(){

                if ($this.options.timeout) {

                    var closefn = function(){ $this.close(); };

                    $this.timeout = setTimeout(closefn, $this.options.timeout);

                    $this.element.hover(
                        function() { clearTimeout($this.timeout); },
                        function() { $this.timeout = setTimeout(closefn, $this.options.timeout);  }
                    );
                }

            });

            return this;
        },

        close: function(instantly) {

            var $this    = this,
                finalize = function(){
                    $this.element.remove();

                    if(!containers[$this.options.pos].children().length) {
                        containers[$this.options.pos].hide();
                    }

                    delete messages[$this.uuid];
                };

            if(this.timeout) clearTimeout(this.timeout);

            if(instantly) {
                finalize();
            } else {
                this.element.animate({"opacity":0, "margin-top": -1* this.element.outerHeight(), "margin-bottom":0}, function(){
                    finalize();
                });
            }
        },

        content: function(html){

            var container = this.element.find(">div");

            if(!html) {
                return container.html();
            }

            container.html(html);

            return this;
        },

        status: function(status) {

            if(!status) {
                return this.currentstatus;
            }

            this.element.removeClass('alert alert-'+this.currentstatus).addClass('alert alert-'+status);

            this.currentstatus = status;

            return this;
        }
    });

    Message.defaults = {
        message: "",
        status: "normal",
        timeout: 5000,
        group: null,
        pos: 'top-center'
    };


    $["notify"]          = notify;
    $["notify"].message  = Message;
    $["notify"].closeAll = closeAll;

    return notify;

}(jQuery, window, document));

// NOW TIMER
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    $('[data-now]').each(function(){
      var element = $(this),
          format = element.data('format');

      function updateTime() {
        var dt = moment( new Date() ).format(format);
        element.text(dt);
      }

      updateTime();
      setInterval(updateTime, 1000);
    
    });
  });

})(window, document, window.jQuery);

/**=========================================================
 * Module: panel-tools.js
 * Dismiss panels
 * [data-tool="panel-dismiss"]
 *
 * Requires animo.js
 =========================================================*/
(function($, window, document){
  'use strict';
  
  var panelSelector = '[data-tool="panel-dismiss"]',
      removeEvent   = 'panel.remove',
      removedEvent  = 'panel.removed';

  $(document).on('click', panelSelector, function () {
    
    // find the first parent panel
    var parent = $(this).closest('.panel');
    var deferred = new $.Deferred();

    // Trigger the event and finally remove the element
    parent.trigger(removeEvent, [parent, deferred]);
    // needs resolve() to be called
    deferred.done(removeElement);

    function removeElement() {
      if($.support.animation) {
        parent.animo({animation: 'bounceOut'}, destroyPanel);
      }
      else destroyPanel();
    }

    function destroyPanel() {
      var col = parent.parent();
      
      $.when(parent.trigger(removedEvent, [parent]))
       .done(function(){
          parent.remove();
          // remove the parent if it is a row and is empty and not a sortable (portlet)
          col
            .trigger(removedEvent) // An event to catch when the panel has been removed from DOM
            .filter(function() {
            var el = $(this);
            return (el.is('[class*="col-"]:not(.sortable)') && el.children('*').length === 0);
          }).remove();
       });

      

    }

  });

}(jQuery, window, document));


/**
 * Collapse panels
 * [data-tool="panel-collapse"]
 *
 * Also uses browser storage to keep track
 * of panels collapsed state
 */
(function($, window, document) {
  'use strict';
  var panelSelector = '[data-tool="panel-collapse"]',
      storageKeyName = 'jq-panelState';

  // Prepare the panel to be collapsable and its events
  $(panelSelector).each(function() {
    // find the first parent panel
    var $this        = $(this),
        parent       = $this.closest('.panel'),
        wrapper      = parent.find('.panel-wrapper'),
        collapseOpts = {toggle: false},
        iconElement  = $this.children('em'),
        panelId      = parent.attr('id');
    
    // if wrapper not added, add it
    // we need a wrapper to avoid jumping due to the paddings
    if( ! wrapper.length) {
      wrapper =
        parent.children('.panel-heading').nextAll() //find('.panel-body, .panel-footer')
          .wrapAll('<div/>')
          .parent()
          .addClass('panel-wrapper');
      collapseOpts = {};
    }

    // Init collapse and bind events to switch icons
    wrapper
      .collapse(collapseOpts)
      .on('hide.bs.collapse', function() {
        setIconHide( iconElement );
        savePanelState( panelId, 'hide' );
      })
      .on('show.bs.collapse', function() {
        setIconShow( iconElement );
        savePanelState( panelId, 'show' );
      });

    // Load the saved state if exists
    var currentState = loadPanelState( panelId );
    if(currentState) {
      setTimeout(function() { wrapper.collapse( currentState ); }, 0);
      savePanelState( panelId, currentState );
    }

  });

  // finally catch clicks to toggle panel collapse
  $(document).on('click', panelSelector, function () {
    
    var parent = $(this).closest('.panel');
    var wrapper = parent.find('.panel-wrapper');

    wrapper.collapse('toggle');

  });

  /////////////////////////////////////////////
  // Common use functions for panel collapse //
  /////////////////////////////////////////////
  function setIconShow(iconEl) {
    iconEl.removeClass('fa-plus').addClass('fa-minus');
  }

  function setIconHide(iconEl) {
    iconEl.removeClass('fa-minus').addClass('fa-plus');
  }

  function savePanelState(id, state) {
    var data = $.localStorage.get(storageKeyName);
    if(!data) { data = {}; }
    data[id] = state;
    $.localStorage.set(storageKeyName, data);
  }

  function loadPanelState(id) {
    var data = $.localStorage.get(storageKeyName);
    if(data) {
      return data[id] || false;
    }
  }


}(jQuery, window, document));


/**
 * Refresh panels
 * [data-tool="panel-refresh"]
 * [data-spinner="standard"]
 */
(function($, window, document){
  'use strict';
  var panelSelector  = '[data-tool="panel-refresh"]',
      refreshEvent   = 'panel.refresh',
      whirlClass     = 'whirl',
      defaultSpinner = 'standard';

  // method to clear the spinner when done
  function removeSpinner(){
    this.removeClass(whirlClass);
  }

  // catch clicks to toggle panel refresh
  $(document).on('click', panelSelector, function () {
      var $this   = $(this),
          panel   = $this.parents('.panel').eq(0),
          spinner = $this.data('spinner') || defaultSpinner
          ;

      // start showing the spinner
      panel.addClass(whirlClass + ' ' + spinner);

      // attach as public method
      panel.removeSpinner = removeSpinner;

      // Trigger the event and send the panel object
      $this.trigger(refreshEvent, [panel]);

  });


}(jQuery, window, document));

/**=========================================================
 * Module: play-animation.js
 * Provides a simple way to run animation with a trigger
 * Targeted elements must have 
 *   [data-animate"]
 *   [data-target="Target element affected by the animation"] 
 *   [data-play="Animation name (http://daneden.github.io/animate.css/)"]
 *
 * Requires animo.js
 =========================================================*/
 
(function($, window, document){
  'use strict';

  var Selector = '[data-animate]';

  $(function() {
    
    var $scroller = $(window).add('body, .wrapper');

    // Parse animations params and attach trigger to scroll
    $(Selector).each(function() {
      var $this     = $(this),
          offset    = $this.data('offset'),
          delay     = $this.data('delay')     || 100, // milliseconds
          animation = $this.data('play')      || 'bounce';
      
      if(typeof offset !== 'undefined') {
        
        // test if the element starts visible
        testAnimation($this);
        // test on scroll
        $scroller.scroll(function(){
          testAnimation($this);
        });

      }

      // Test an element visibilty and trigger the given animation
      function testAnimation(element) {
          if ( !element.hasClass('anim-running') &&
              $.Utils.isInView(element, {topoffset: offset})) {
          element
            .addClass('anim-running');

          setTimeout(function() {
            element
              .addClass('anim-done')
              .animo( { animation: animation, duration: 0.7} );
          }, delay);

        }
      }

    });

    // Run click triggered animations
    $(document).on('click', Selector, function() {

      var $this     = $(this),
          targetSel = $this.data('target'),
          animation = $this.data('play') || 'bounce',
          target    = $(targetSel);

      if(target && target) {
        target.animo( { animation: animation } );
      }
      
    });

  });

}(jQuery, window, document));

/**=========================================================
 * Module: portlet.js
 * Drag and drop any panel to change its position
 * The Selector should could be applied to any object that contains
 * panel, so .col-* element are ideal.
 =========================================================*/

(function($, window, document){
  'use strict';

  // Component is optional
  if(!$.fn.sortable) return;

  var Selector = '[data-toggle="portlet"]',
      storageKeyName = 'jq-portletState';

  $(function(){

    $( Selector ).sortable({
      connectWith:          Selector,
      items:                'div.panel',
      handle:               '.portlet-handler',
      opacity:              0.7,
      placeholder:          'portlet box-placeholder',
      cancel:               '.portlet-cancel',
      forcePlaceholderSize: true,
      iframeFix:            false,
      tolerance:            'pointer',
      helper:               'original',
      revert:               200,
      forceHelperSize:      true,
      update:               savePortletOrder,
      create:               loadPortletOrder
    })
    // optionally disables mouse selection
    //.disableSelection()
    ;

  });

  function savePortletOrder(event, ui) {
    
    var data = $.localStorage.get(storageKeyName);
    
    if(!data) { data = {}; }

    data[this.id] = $(this).sortable('toArray');

    if(data) {
      $.localStorage.set(storageKeyName, data);
    }
    
  }

  function loadPortletOrder() {
    
    var data = $.localStorage.get(storageKeyName);

    if(data) {
      
      var porletId = this.id,
          panels   = data[porletId];

      if(panels) {
        var portlet = $('#'+porletId);
        
        $.each(panels, function(index, value) {
           $('#'+value).appendTo(portlet);
        });
      }

    }

  }

}(jQuery, window, document));


// SIDEBAR
// ----------------------------------- 


(function(window, document, $, undefined){

  var $win;
  var $html;
  var $body;
  var $sidebar;
  var mq;

  $(function(){

    $win     = $(window);
    $html    = $('html');
    $body    = $('body');
    $sidebar = $('.sidebar');
    mq       = APP_MEDIAQUERY;
    
    // AUTOCOLLAPSE ITEMS 
    // ----------------------------------- 

    var sidebarCollapse = $sidebar.find('.collapse');
    sidebarCollapse.on('show.bs.collapse', function(event){

      event.stopPropagation();
      if ( $(this).parents('.collapse').length === 0 )
        sidebarCollapse.filter('.in').collapse('hide');

    });

    
    // SIDEBAR ACTIVE STATE 
    // ----------------------------------- 
    
    // Find current active item
    var currentItem = $('.sidebar .active').parents('li');

    currentItem
      .addClass('active')     // activate the parent
      .children('.collapse')  // find the collapse
      .collapse('show');      // and show it


    // SIDEBAR COLLAPSED ITEM HANDLER
    // ----------------------------------- 


    var eventName = isTouch() ? 'click' : 'mouseenter' ;
    var subNav = $();
    $sidebar.on( eventName, '.nav > li', function() {

      if( isSidebarCollapsed() && !isMobile() ) {

        subNav.trigger('mouseleave');
        subNav = toggleMenuItem( $(this) );

      }

    });

  });


  // Open the collapse sidebar submenu items when on touch devices 
  // - desktop only opens on hover
  function toggleTouchItem($element){
    $element
      .siblings('li')
      .removeClass('open')
      .end()
      .toggleClass('open');
  }

  // Handles hover to open items under collapsed menu
  // ----------------------------------- 
  function toggleMenuItem($listItem) {

    removeFloatingNav();

    var ul = $listItem.children('ul');
    
    if( !ul.length ) return $();
    if( $listItem.hasClass('open') ) {
      toggleTouchItem($listItem);
      return $();
    }

    var $aside = $('.aside');
    var mar = parseInt( $aside.css('padding-top'), 0);

    var subNav = ul.clone().appendTo( $aside );
    
    toggleTouchItem($listItem);

    var itemTop = ($listItem.position().top + mar) - $sidebar.scrollTop();
    var vwHeight = $win.height();

    subNav
      .addClass('nav-floating')
      .css({
        position: isFixed() ? 'fixed' : 'absolute',
        top:      itemTop,
        bottom:   (subNav.outerHeight(true) + itemTop > vwHeight) ? 0 : 'auto'
      });

    subNav.on('mouseleave', function() {
      toggleTouchItem($listItem);
      subNav.remove();
    });

    return subNav;
  }

  function removeFloatingNav() {
    $('.sidebar-subnav.nav-floating').remove();
  }

  function isTouch() {
    return $html.hasClass('touch');
  }
  function isSidebarCollapsed() {
    return $body.hasClass('aside-collapsed');
  }
  function isSidebarToggled() {
    return $body.hasClass('aside-toggled');
  }
  function isMobile() {
    return $win.width() < mq.tablet;
  }
  function isFixed(){
    return $body.hasClass('layout-fixed');
  }

})(window, document, window.jQuery);
// SKYCONS
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    $('[data-skycon]').each(function(){
      var element = $(this),
          skycons = new Skycons({'color': (element.data('color') || 'white')});
      
      element.html('<canvas width="' + element.data('width') + '" height="' + element.data('height') + '"></canvas>');

      skycons.add(element.children()[0], element.data('skycon'));

      skycons.play();
    });

  });

})(window, document, window.jQuery);
// SLIMSCROLL
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    $('[data-scrollable]').each(function(){

      var element = $(this),
          defaultHeight = 250;
      
      element.slimScroll({
          height: (element.data('height') || defaultHeight)
      });
      
    });
  });

})(window, document, window.jQuery);

// SPARKLINE
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    $('[data-sparkline]').each(initSparkLine);

    function initSparkLine() {
      var $element = $(this),
          options = $element.data(),
          values  = options.values && options.values.split(',');

      options.type = options.type || 'bar'; // default chart is bar
      options.disableHiddenCheck = true;

      $element.sparkline(values, options);

      if(options.resize) {
        $(window).resize(function(){
          $element.sparkline(values, options);
        });
      }
    }
  });

})(window, document, window.jQuery);

// Custom jQuery
// ----------------------------------- 


(function(window, document, $, undefined){

  $(function(){

    $('[data-check-all]').on('change', function() {
      var $this = $(this),
          index= $this.index() + 1,
          checkbox = $this.find('input[type="checkbox"]'),
          table = $this.parents('table');
      // Make sure to affect only the correct checkbox column
      table.find('tbody > tr > td:nth-child('+index+') input[type="checkbox"]')
        .prop('checked', checkbox[0].checked);

    });

  });

})(window, document, window.jQuery);


// TOGGLE STATE
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    var $body = $('body');
        toggle = new StateToggler();

    $('[data-toggle-state]')
      .on('click', function (e) {
        // e.preventDefault();
        var element = $(this),
            classname = element.data('toggleState'),
            noPersist = (element.attr('data-no-persist') !== undefined);

        if(classname) {
          if( $body.hasClass(classname) ) {
            $body.removeClass(classname);
            if( ! noPersist)
              toggle.removeState(classname);
          }
          else {
            $body.addClass(classname);
            if( ! noPersist)
              toggle.addState(classname);
          }
          
        }

    });

  });

  // Handle states to/from localstorage
  window.StateToggler = function() {

    var storageKeyName  = 'jq-toggleState';

    // Helper object to check for words in a phrase //
    var WordChecker = {
      hasWord: function (phrase, word) {
        return new RegExp('(^|\\s)' + word + '(\\s|$)').test(phrase);
      },
      addWord: function (phrase, word) {
        if (!this.hasWord(phrase, word)) {
          return (phrase + (phrase ? ' ' : '') + word);
        }
      },
      removeWord: function (phrase, word) {
        if (this.hasWord(phrase, word)) {
          return phrase.replace(new RegExp('(^|\\s)*' + word + '(\\s|$)*', 'g'), '');
        }
      }
    };

    // Return service public methods
    return {
      // Add a state to the browser storage to be restored later
      addState: function(classname){
        var data = $.localStorage.get(storageKeyName);
        
        if(!data)  {
          data = classname;
        }
        else {
          data = WordChecker.addWord(data, classname);
        }

        $.localStorage.set(storageKeyName, data);
      },

      // Remove a state from the browser storage
      removeState: function(classname){
        var data = $.localStorage.get(storageKeyName);
        // nothing to remove
        if(!data) return;

        data = WordChecker.removeWord(data, classname);

        $.localStorage.set(storageKeyName, data);
      },
      
      // Load the state string and restore the classlist
      restoreState: function($elem) {
        var data = $.localStorage.get(storageKeyName);
        
        // nothing to restore
        if(!data) return;
        $elem.addClass(data);
      }

    };
  };

})(window, document, window.jQuery);

/**=========================================================
 * Module: utils.js
 * jQuery Utility functions library 
 * adapted from the core of UIKit
 =========================================================*/

(function($, window, doc){
    'use strict';
    
    var $html = $("html"), $win = $(window);

    $.support.transition = (function() {

        var transitionEnd = (function() {

            var element = doc.body || doc.documentElement,
                transEndEventNames = {
                    WebkitTransition: 'webkitTransitionEnd',
                    MozTransition: 'transitionend',
                    OTransition: 'oTransitionEnd otransitionend',
                    transition: 'transitionend'
                }, name;

            for (name in transEndEventNames) {
                if (element.style[name] !== undefined) return transEndEventNames[name];
            }
        }());

        return transitionEnd && { end: transitionEnd };
    })();

    $.support.animation = (function() {

        var animationEnd = (function() {

            var element = doc.body || doc.documentElement,
                animEndEventNames = {
                    WebkitAnimation: 'webkitAnimationEnd',
                    MozAnimation: 'animationend',
                    OAnimation: 'oAnimationEnd oanimationend',
                    animation: 'animationend'
                }, name;

            for (name in animEndEventNames) {
                if (element.style[name] !== undefined) return animEndEventNames[name];
            }
        }());

        return animationEnd && { end: animationEnd };
    })();

    $.support.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || window.oRequestAnimationFrame || function(callback){ window.setTimeout(callback, 1000/60); };
    $.support.touch                 = (
        ('ontouchstart' in window && navigator.userAgent.toLowerCase().match(/mobile|tablet/)) ||
        (window.DocumentTouch && document instanceof window.DocumentTouch)  ||
        (window.navigator['msPointerEnabled'] && window.navigator['msMaxTouchPoints'] > 0) || //IE 10
        (window.navigator['pointerEnabled'] && window.navigator['maxTouchPoints'] > 0) || //IE >=11
        false
    );
    $.support.mutationobserver      = (window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver || null);

    $.Utils = {};

    $.Utils.debounce = function(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    $.Utils.removeCssRules = function(selectorRegEx) {
        var idx, idxs, stylesheet, _i, _j, _k, _len, _len1, _len2, _ref;

        if(!selectorRegEx) return;

        setTimeout(function(){
            try {
              _ref = document.styleSheets;
              for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                stylesheet = _ref[_i];
                idxs = [];
                stylesheet.cssRules = stylesheet.cssRules;
                for (idx = _j = 0, _len1 = stylesheet.cssRules.length; _j < _len1; idx = ++_j) {
                  if (stylesheet.cssRules[idx].type === CSSRule.STYLE_RULE && selectorRegEx.test(stylesheet.cssRules[idx].selectorText)) {
                    idxs.unshift(idx);
                  }
                }
                for (_k = 0, _len2 = idxs.length; _k < _len2; _k++) {
                  stylesheet.deleteRule(idxs[_k]);
                }
              }
            } catch (_error) {}
        }, 0);
    };

    $.Utils.isInView = function(element, options) {

        var $element = $(element);

        if (!$element.is(':visible')) {
            return false;
        }

        var window_left = $win.scrollLeft(),
            window_top  = $win.scrollTop(),
            offset      = $element.offset(),
            left        = offset.left,
            top         = offset.top;

        options = $.extend({topoffset:0, leftoffset:0}, options);

        if (top + $element.height() >= window_top && top - options.topoffset <= window_top + $win.height() &&
            left + $element.width() >= window_left && left - options.leftoffset <= window_left + $win.width()) {
          return true;
        } else {
          return false;
        }
    };

    $.Utils.options = function(string) {

        if ($.isPlainObject(string)) return string;

        var start = (string ? string.indexOf("{") : -1), options = {};

        if (start != -1) {
            try {
                options = (new Function("", "var json = " + string.substr(start) + "; return JSON.parse(JSON.stringify(json));"))();
            } catch (e) {}
        }

        return options;
    };

    $.Utils.events       = {};
    $.Utils.events.click = $.support.touch ? 'tap' : 'click';

    $.langdirection = $html.attr("dir") == "rtl" ? "right" : "left";

    $(function(){

        // Check for dom modifications
        if(!$.support.mutationobserver) return;

        // Install an observer for custom needs of dom changes
        var observer = new $.support.mutationobserver($.Utils.debounce(function(mutations) {
            $(doc).trigger("domready");
        }, 300));

        // pass in the target node, as well as the observer options
        observer.observe(document.body, { childList: true, subtree: true });

    });

    // add touch identifier class
    $html.addClass($.support.touch ? "touch" : "no-touch");

}(jQuery, window, document));
// Custom jQuery
// ----------------------------------- 


(function(window, document, $, undefined){

  $(function(){

    // document ready

  });

})(window, document, window.jQuery);