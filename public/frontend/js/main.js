(function ($) {
  ("user strict");

  // preloader
  $(window).on("load", function () {
    $(".preloader")
      .delay(800)
      .animate(
        {
          opacity: "0",
        },
        800,
        function () {
          $(".preloader").css("display", "none");
        }
      );
  });

  $(".nice-select").niceSelect();

  //Create Background Image
  (function background() {
    let img = $(".bg_img");
    img.css("background-image", function () {
      var bg = "url(" + $(this).data("background") + ")";
      return bg;
    });
  })();

  (function background() {
    let img = $(".bg_img-2");
    img.css("background-image", function () {
      var bg = "url(" + $(this).data("background") + ")";
      return bg;
    });
  })();

  // lightcase
  $(window).on("load", function () {
    $("a[data-rel^=lightcase]").lightcase();
  });

  // header-fixed
  var fixed_top = $(".header-section");
  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 100) {
      fixed_top.addClass("animated fadeInDown header-fixed");
    } else {
      fixed_top.removeClass("animated fadeInDown header-fixed");
    }
  });

  // navbar-click
  $(".navbar li a").on("click", function () {
    var element = $(this).parent("li");
    if (element.hasClass("show")) {
      element.removeClass("show");
      element.children("ul").slideUp(500);
    } else {
      element.siblings("li").removeClass("show");
      element.addClass("show");
      element.siblings("li").find("ul").slideUp(500);
      element.children("ul").slideDown(500);
    }
  });

  // scroll-to-top
  var ScrollTop = $(".scrollToTop");
  $(window).on("scroll", function () {
    if ($(this).scrollTop() < 100) {
      ScrollTop.removeClass("active");
    } else {
      ScrollTop.addClass("active");
    }
  });

  // sidebar
  $(".sidebar-menu-item > a").on("click", function () {
    var element = $(this).parent("li");
    if (element.hasClass("active")) {
      element.removeClass("active");
      element.children("ul").slideUp(500);
    } else {
      element.siblings("li").removeClass("active");
      element.addClass("active");
      element.siblings("li").find("ul").slideUp(500);
      element.children("ul").slideDown(500);
    }
  });

  //sidebar Menu
  $(document).on("click", ".navbar__expand", function () {
    $(".sidebar").toggleClass("active");
    $(".navbar-wrapper").toggleClass("active");
    $(".body-wrapper").toggleClass("active");
  });

  // Mobile Menu
  $(".sidebar-mobile-menu").on("click", function () {
    $(".sidebar__menu").slideToggle();
  });

  // faq
  $(".faq-wrapper .faq-title").on("click", function (e) {
    var element = $(this).parent(".faq-item");
    if (element.hasClass("open")) {
      element.removeClass("open");
      element.find(".faq-content").removeClass("open");
      element.find(".faq-content").slideUp(300, "swing");
    } else {
      element.addClass("open");
      element.children(".faq-content").slideDown(300, "swing");
      element
        .siblings(".faq-item")
        .children(".faq-content")
        .slideUp(300, "swing");
      element.siblings(".faq-item").removeClass("open");
      element.siblings(".faq-item").find(".faq-title").removeClass("open");
      element.siblings(".taq-item").find(".faq-content").slideUp(300, "swing");
    }
  });

  //Odometer
  if ($(".statistics-item,.icon-box-items,.counter-single-items").length) {
    $(".statistics-item,.icon-box-items,.counter-single-items").each(
      function () {
        $(this).isInViewport(function (status) {
          if (status === "entered") {
            for (
              var i = 0;
              i < document.querySelectorAll(".odometer").length;
              i++
            ) {
              var el = document.querySelectorAll(".odometer")[i];
              el.innerHTML = el.getAttribute("data-odometer-final");
            }
          }
        });
      }
    );
  }

  var swiper = new Swiper(".brand-slider", {
    slidesPerView: 6,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      speed: 1000,
      delay: 3000,
    },
    speed: 1000,
    breakpoints: {
      1199: {
        slidesPerView: 5,
      },
      991: {
        slidesPerView: 4,
      },
      767: {
        slidesPerView: 3,
      },
      575: {
        slidesPerView: 2,
      },
    },
  });

  $('.select2-basic').select2();
  $('.select2-dy-option').select2({
    tags:true,
  });

  $(".show_hide_password .show-pass").on('click', function(event) {
      event.preventDefault();
      if($(this).parent().find("input").attr("type") == "text"){
          $(this).parent().find("input").attr('type', 'password');
          $(this).find("i").addClass( "fa-eye-slash" );
          $(this).find("i").removeClass( "fa-eye" );
      }else if($(this).parent().find("input").attr("type") == "password"){
          $(this).parent().find("input").attr('type', 'text');
          $(this).find("i").removeClass( "fa-eye-slash" );
          $(this).find("i").addClass( "fa-eye" );
      }
  });
  
})(jQuery);

//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if(mybutton == null) return;
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
if(mybutton) {
  mybutton.addEventListener("click", backToTop);
}

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}


/**
 * Function for open delete modal with method DELETE
 * @param {string} URL 
 * @param {string} target 
 * @param {string} message 
 * @returns 
 */
function openAlertModal(URL,target,message,actionBtnText = "Remove",method = "DELETE", CloseBtnText= "Close"){
  if(URL == "" || target == "") {
      return false;
  }

  if(message == "") {
      message = "Are you sure to delete ?";
  }
  var method = `<input type="hidden" name="_method" value="${method}">`;
  openModalByContent(
      {
          content: `<div class="card modal-alert border-0">
                      <div class="card-body">
                          <form method="POST" action="${URL}">
                              <input type="hidden" name="_token" value="${laravelCsrf()}">
                              ${method}
                              <div class="head mb-3">
                                  ${message}
                                  <input type="hidden" name="target" value="${target}">
                              </div>
                              <div class="foot d-flex align-items-center justify-content-between">
                                  <button type="button" class="modal-close btn btn--base bg-danger border-0">${CloseBtnText}</button>
                                  <button type="submit" class="alert-submit-btn btn btn--base bg--danger border-0 btn-loading">${actionBtnText}</button>
                              </div>    
                          </form>
                      </div>
                  </div>`,
      },

  );
}

/**
 * Function For Open Modal Instant by pushing HTML Element
 * @param {Object} data
 */
function openModalByContent(data = {
  content:"",
  animation: "mfp-move-horizontal",
  size: "medium",
}) {
  $.magnificPopup.open({
    removalDelay: 500,
    items: {
      src: `<div class="white-popup mfp-with-anim ${data.size ?? "medium"}">${data.content}</div>`, // can be a HTML string, jQuery object, or CSS selector
    },
    callbacks: {
      beforeOpen: function() {
        this.st.mainClass = data.animation ?? "mfp-move-horizontal";
      },
      open: function() {
        var modalCloseBtn = this.contentContainer.find(".modal-close");
        $(modalCloseBtn).click(function() {
          $.magnificPopup.close();
        });
      },
    },
    midClick: true,
  });
}

/**
 * Function for getting CSRF token for form submit in laravel
 * @returns string
 */
function laravelCsrf() {
  return $("head meta[name=csrf-token]").attr("content");
}

/**
 * Function For Get All Country list by AJAX Request
 * @param {HTML DOM} targetElement
 * @param {Error Place Element} errorElement
 * @returns
 */
var allCountries = "";
function getAllCountries(hitUrl,targetElement = $(".country-select"),errorElement = $(".country-select").siblings(".select2")) {
  if(targetElement.length == 0) {
    return false;
  }
  var CSRF = $("meta[name=csrf-token]").attr("content");
  var data = {
      _token      : CSRF,
  };
  $.post(hitUrl,data,function() {
      // success
      $(errorElement).removeClass("is-invalid");
      $(targetElement).siblings(".invalid-feedback").remove();
  }).done(function(response){
      // Place States to States Field
      var options = "<option selected disabled>Select Country</option>";
      var selected_old_data = "";
      if($(targetElement).attr("data-old") != null) {
          selected_old_data = $(targetElement).attr("data-old");
      }
      $.each(response,function(index,item) {
          options += `<option value="${item.name}" data-id="${item.id}" data-mobile-code="${item.mobile_code}" data-currency-name="${item.currency_name}" data-currency-code="${item.currency_code}" data-currency-symbol="${item.currency_symbol}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
      });

      allCountries = response;

      $(targetElement).html(options);
  }).fail(function(response) {
      var faildMessage = "Something went wrong! Please try again.";
      var faildElement = `<span class="invalid-feedback" role="alert">
                              <strong>${faildMessage}</strong>
                          </span>`;
      $(errorElement).addClass("is-invalid");
      if($(targetElement).siblings(".invalid-feedback").length != 0) {
          $(targetElement).siblings(".invalid-feedback").text(faildMessage);
      }else {
          errorElement.after(faildElement);
      }
  });
}

// Customize all number input to type=text for dot(.) input related issue
$(document).on("keyup",".number-input",function(){
  var pattern = /^[0-9]*\.?[0-9]*$/;
  var value = $(this).val();
  var test = pattern.test(value);
  if(test == false) {
    var rightValue = value;
    if(value.length > 0) {
      for (let index = 0; index < value.length; index++){
        if(!$.isNumeric(rightValue)) {
          rightValue = rightValue.slice(0, -1);
        }
      }
    }
    $(this).val(rightValue);
  }
});


let formDebounceTimer;
function handleDebounceForm(element) {
  if(formDebounceTimer) {
    clearTimeout(formDebounceTimer);
  }
  formDebounceTimer =  setTimeout(() => {
    element.submit();
  }, 500);
}

var htmlForms = document.querySelectorAll("form.bounce-safe");
htmlForms.forEach(function(item) {
  item.addEventListener("submit",function(event) {
    event.preventDefault();
    handleDebounceForm(this);
  });
});


/**
 * Function For Open Modal with CSS Selector Ex: "#modal-popup"
 * @param {String} selector
 * @param {String} animation
 */
function openModalBySelector(selector,animation = "mfp-move-horizontal") {
  $(selector).addClass("white-popup mfp-with-anim");
  if(animation == null) {
    animation = "mfp-zoom-in"
  }
  $.magnificPopup.open({
    removalDelay: 500,
    items: {
      src: $(selector), // can be a HTML string, jQuery object, or CSS selector
      type: 'inline',
    },

    callbacks: {
      beforeOpen: function() {
        this.st.mainClass = animation;
      },
      elementParse: function(item) {
        var modalCloseBtn = $(selector).find(".modal-close");
        $(modalCloseBtn).click(function() {
          $.magnificPopup.close();
        });
      },
    },
  });
  $.magnificPopup.instance._onFocusIn = function(e) {
    // Do nothing if target element is select2 input
    if( $(e.target).hasClass('select2-search__field') ) {
        return true;
    }
    // Else call parent method
    $.magnificPopup.proto._onFocusIn.call(this,e);
  }
}

function removeTrailingZeros(str) {
  // return str.replace(/^0+(\d)|(\d)0+$/gm, '$1$2');
  return str;
}

$(".copy-button").click(function(){
  var copyableElement = $(this).siblings(".copiable");

  var value = "";
  if(copyableElement.is("input")) {
    value = $(this).siblings(".copiable").val();
  }else {
    value = $(this).siblings(".copiable").text();
  }
  navigator.clipboard.writeText(value);
  throwMessage('success',['Text successfully copied.']);
});

var activeNav = $(".sidebar-submenu .nav-link.active");
if(activeNav.length > 0) {
  activeNav.parents(".sidebar-submenu").addClass("open");
  activeNav.parents(".sidebar-dropdown").addClass("active");
}