<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Calculator</title>
	<link rel="stylesheet" href="css/app.css">

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
</head>
<body>

	<section id="calculator" class="top200">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-push-3">
					<input type="text" name="screen" class="screen input-md" readonly="">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-push-3">
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="1">1</button>
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="2">2</button>
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="3">3</button>
					<button class="btn btn-success btn-calc" data-func="operator" data-value="+">+</button>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-push-3">
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="4">4</button>
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="5">5</button>
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="6">6</button>
					<button class="btn btn-success btn-calc" data-func="operator" data-value="-">-</button>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-push-3">
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="7">7</button>
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="8">8</button>
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="9">9</button>
					<button class="btn btn-success btn-calc" data-func="operator" data-value="*">*</button>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-push-3">
					<button class="btn btn-primary btn-calc" data-func="digit" data-value="0">0</button>
					<button class="btn btn-success btn-calc" data-func="operator" data-value="/">/</button>
					<button class="btn btn-success btn-calc" data-func="operator" data-value="MOD">MOD</button>
					<button class="btn btn-success btn-calc" data-loading="loading" data-func="operator" data-value="=">=</button>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-push-3">
					<button class="btn btn-danger btn-calc full" data-func="reset">RESET</button>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript">
	$(function() {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});


		$(".btn-calc").on('click', function() {
			var $this = $(this),
				$calculator = $("#calculator"),
				$screen = $("input.screen"),
				state = $calculator.attr('data-state') || 'digit',
				strFun = $this.attr('data-func'),
				strVal = $this.attr('data-value');

			if (strFun == 'reset') {
				$screen.val('');
				$calculator.attr('data-state', 'digit');
				return;
			}

			if (strVal == '=') {
				var val = $screen.val();
				$screen.val($this.attr('data-loading'));
				$.ajax({
					url: '{{ route('calc') }}',
					data: {
						'calc': val
					},
					method: 'POST',
					success: function(rxp) {

						if (rxp.bonus) {
							alert("You won");
						}

						if (rxp.error) {
							alert("An error occour");
							$screen.val("ERRO");
						} else if(rxp.result) {
							$screen.val(rxp.result);
							$calculator.attr('data-state', 'operator');
						}
					}
				});
				return;
			}

			if (state == strFun) {
				$screen.val($screen.val()+' '+strVal);
				if (state == 'digit') {
					$calculator.attr('data-state', 'operator');
				}else{
					$calculator.attr('data-state', 'digit');
				}
			}

		});
	});
	</script>

</body>
</html>