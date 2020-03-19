import { mainRender } from './public/JS/events/main.js';
import { singleBusinessRender } from './public/JS/events/singleBusiness.js';
import { customerFormRender } from './public/JS/events/customerForm.js';

$(document).ready(async function() {
	// screen helper
	screenSizeHandler();

	// main url
	const apiUrl = `http://localhost/assignment/api/`;

	await mainRender(apiUrl, $('.mainRender'), './public/screens/businessesList.html');

	$('.openBtn').click(async function() {
		// declare the business id(token)
		const businessToken = $(this).attr('data-token');
		await singleBusinessRender(apiUrl, businessToken, $('.mainRender'), './public/screens/singleBusiness.html');

		// open modal
		$('.modal').modal();
		$('.edit-customer').click(async function(e) {
			// declare customer id (token)
			const customerToken = $(this).attr('data-token');

			await customerFormRender(apiUrl, customerToken, $('#modal_form'), './public/screens/form.html');

			$('.modal').modal('open');

			$('#customer_form_edit').submit(async function(e) {
				e.preventDefault();
				const data = serializeData($('#customer_form_edit'));
				await fetchData(`${apiUrl}/customer/update_customer.php`, data, 'POST');

				await singleBusinessRender(
					apiUrl,
					businessToken,
					$('.mainRender'),
					'./public/screens/singleBusiness.html',
				);
			});
		});
		$('.add-customer').click(async function(e) {
			const business_token = $(this).attr('data-token');
			const renderResult = await render({ business_token, form: 'add' }, 'form.html');
			$('.modal-content').html(renderResult);
			$('.modal').modal('open');

			$('#customer_form_add').submit(async function(e) {
				e.preventDefault();
				const data = serializeData($('#customer_form_add'));

				data.businessToken = business_token;
				const customer_token = await fetchData(`${apiUrl}/customer/add_customer.php`, data, 'POST');

				$('#customers').prepend(` 
					<li data-token="${customer_token}" class="collection-item">
						<p>${data.customer_name} <br>Email: ${data.customer_email}</p>
						<span data-token="${customer_token}" class="secondary-content edit-customer"><i class="material-icons">edit</i></span>
					</li> `);

				$('.modal').modal('close');
			});
		});
		$('.is-active').change(function() {
			const businessToken = $(this).attr('data-token');
			const data = { businessToken };
			console.log(data);

			let labelText = '';
			if ($(this).prop('checked')) {
				// checked

				data.operation = 'activate';
				labelText = 'Deactivate';

				fetchData(`${apiUrl}/business/change_activity.php`, data, 'POST');
			} else {
				// not checked
				labelText = 'Activate';
				data.operation = 'deactivate';
				fetchData(`${apiUrl}/business/change_activity.php`, data, 'POST');
			}
			$(this).next().text(labelText);
			return;
		});
	});
});
$(window).on('resize', function() {
	screenSizeHandler();
});
