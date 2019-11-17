<script src="https://js.stripe.com/v3/"></script>
<form action="<?=cn('payment/stripe/process')?>" method="post" id="payment-form">
	<input type="hidden" name="ids" value="<?=$package->ids?>">
	<div class="form-row mt15">
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>
  	</div>

    <button type="submit" class="btn btn-dark btn-lg btn-block mt15"><?=lang('submit_payment')?></button>
</form>		

<script type="text/javascript">
setTimeout(function(){
	// Create a Stripe client
	var stripe = Stripe('<?=get_option('stripe_publishable_key')?>');

	// Create an instance of Elements
	var elements = stripe.elements();

	// Custom styling can be passed to options when creating an Element.
	// (Note that this demo uses a wider set of styles than the guide below.)
	var style = {
		hidePostalCode: true,
	  	base: {
			color: '#32325d',
			lineHeight: '18px',
			fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
			fontSmoothing: 'antialiased',
			fontSize: '16px',
			'::placeholder': {
				color: '#aab7c4'
			}
	  	},
	  	invalid: {
		    color: '#fa755a',
		    iconColor: '#fa755a'
	  	}
	};

	// Create an instance of the card Element
	var card = elements.create('card', {style: style});

	// Add an instance of the card Element into the `card-element` <div>
	card.mount('#card-element');

	// Handle real-time validation errors from the card Element.
	card.addEventListener('change', function(event) {
	  	var displayError = document.getElementById('card-errors');
	  	if (event.error) {
	    	displayError.textContent = event.error.message;
	  	} else {
	    	displayError.textContent = '';
	  	}
	});

	// Handle form submission
	var form = document.getElementById('payment-form');
	form.addEventListener('submit', function(event) {
	  	event.preventDefault();

	  	stripe.createToken(card).then(function(result) {
		    if (result.error) {
				// Inform the user if there was an error
				var errorElement = document.getElementById('card-errors');
				errorElement.textContent = result.error.message;
		    } else {
		      	// Send the token to your server
		      	stripeTokenHandler(result.token);
	    	}
	  	});
	});
}, 1000);

function stripeTokenHandler(stripe_token) {
	// Insert the token ID into the form so it gets submitted to the server
	var form = document.getElementById('payment-form');
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'stripeToken');
	hiddenInput.setAttribute('value', stripe_token.id);
	form.appendChild(hiddenInput);

	var hiddenToken = document.createElement('input');
	hiddenToken.setAttribute('type', 'hidden');
	hiddenToken.setAttribute('name', 'token');
	hiddenToken.setAttribute('value', token);
	form.appendChild(hiddenToken);

	var hiddenPlan = document.createElement('input');
	hiddenPlan.setAttribute('type', 'hidden');
	hiddenPlan.setAttribute('name', 'plan');
	hiddenPlan.setAttribute('value', $('input[name="plan"]:checked').val());
	form.appendChild(hiddenPlan);

	// Submit the form
	form.submit();
}
</script>