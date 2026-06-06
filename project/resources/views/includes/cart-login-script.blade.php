<script type="text/javascript">
(function ($) {
  "use strict";

  var pendingCartAction = null;

  function getPendingCartAction() {
    if (pendingCartAction) {
      return pendingCartAction;
    }
    try {
      var stored = sessionStorage.getItem('pendingCartAction');
      return stored ? JSON.parse(stored) : null;
    } catch (e) {
      return null;
    }
  }

  function setPendingCartAction(action) {
    pendingCartAction = action;
    if (action) {
      sessionStorage.setItem('pendingCartAction', JSON.stringify(action));
    } else {
      sessionStorage.removeItem('pendingCartAction');
    }
  }

  function clearPendingCartAction() {
    pendingCartAction = null;
    sessionStorage.removeItem('pendingCartAction');
  }

  function showLoginModalForCart(action) {
    setPendingCartAction(action);
    $('#comment-log-reg').modal('show');
  }

  function handleAddToCartResponse(data) {
    if (data == 'digital') {
      toastr.error(langg.already_cart);
    } else if (data == 0) {
      toastr.error(langg.out_stock);
    } else {
      $('#cart-count').html(data[0]);
      $('#cart-items').load(mainurl + '/carts/view');
      toastr.success(langg.add_cart);
    }
  }

  window.executePendingCartAction = function () {
    var action = getPendingCartAction();
    if (!action) {
      return false;
    }

    clearPendingCartAction();

    if (action.action === 'cart') {
      $.get(action.href, function (data) {
        handleAddToCartResponse(data);
      });
    } else if (action.action === 'buynow') {
      window.location = action.href;
    }

    return true;
  };

  $(document).ready(function () {
    if (typeof isLoggedIn !== 'undefined' && isLoggedIn) {
      executePendingCartAction();
    }

    $(document).off('click', '.add-to-cart').on('click', '.add-to-cart', function (e) {
      e.preventDefault();

      var href = $(this).data('href');

      if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
        showLoginModalForCart({ href: href, action: 'cart' });
        return false;
      }

      $.get(href, function (data) {
        handleAddToCartResponse(data);
      });

      return false;
    });

    $(document).off('click', '.add-to-cart-quick').on('click', '.add-to-cart-quick', function (e) {
      e.preventDefault();

      var href = $(this).data('href');

      if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
        showLoginModalForCart({ href: href, action: 'buynow' });
        return false;
      }

      window.location = href;
    });

    $('.mloginform').off('submit').on('submit', function (e) {
      var $form = $(this);
      var $this = $form.parent();
      e.preventDefault();
      $this.find('button.submit-btn').prop('disabled', true);
      $this.find('.alert-info').show();
      var authdata = $this.find('.mauthdata').val();
      $('.signin-form .alert-info p').html(authdata);
      $.ajax({
        method: 'POST',
        url: $form.prop('action'),
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          if (data.errors) {
            $this.find('.alert-success').hide();
            $this.find('.alert-info').hide();
            $this.find('.alert-danger').show();
            $this.find('.alert-danger ul').html('');
            for (var error in data.errors) {
              $('.signin-form .alert-danger p').html(data.errors[error]);
            }
          } else {
            $this.find('.alert-info').hide();
            $this.find('.alert-danger').hide();
            $this.find('.alert-success').show();
            $this.find('.alert-success p').html('Success !');
            if (data == 1) {
              isLoggedIn = true;
              if (getPendingCartAction()) {
                $('#comment-log-reg').modal('hide');
                setTimeout(function () {
                  executePendingCartAction();
                }, 300);
              } else {
                location.reload();
              }
            } else {
              window.location = data;
            }
          }
          $this.find('button.submit-btn').prop('disabled', false);
        }
      });
    });
  });
})(jQuery);
</script>
