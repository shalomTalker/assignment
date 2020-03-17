$(document).ready(async function () {
	// screen helper 
	screenSizeHandler();

	// main url
	const apiUrl = '/api/';

	// fetch all customers
	let buisnessListJson = await fetchData(`${apiUrl}business/get_all.php`);

	// map on list and add some new values 
	buisnessListJson = buisnessListJson.map((buisness) => {
		buisness.isActive = (buisness.businessIsActive === 'Yes');
		buisness.activeSince = formatDate(buisness.businessCreationDate);
		return buisness;
	});
	console.log(buisnessListJson[0].isActive);

	// render list of businesses to template
	const renderResult = await render({ buisnessListJson }, 'businessesList.html');
	// implement html to main div
	$('.mainRender').html(renderResult);

	$('.openBtn').click(async function () {
		// declare the business id(token)
		const businessToken = $(this).attr('data-token');

		const businessJson = await fetchData(`${apiUrl}/business/get_one.php`, { businessToken }, 'POST');
		let customersJson = await fetchData(`${apiUrl}/customer/get_all.php`, { businessToken }, 'POST');
		// add more values to business object 
		businessJson.isActive = (businessJson.businessIsActive === 'Yes');
		businessJson.activeSince = formatDate(businessJson.businessCreationDate);
		businessJson.businessFeatures = businessJson.businessFeatures.map((feature) => {
			feature.isActive = (feature.featureActive === 'Yes');
			return feature;
		});


		// render one business and his list of customers to template
		const renderResult = await render({ businessJson, customersJson }, 'singleBusiness.html');
		// implement html to main div
		$('.mainRender').html(renderResult);
		// open modal
		$('.modal').modal();
		$('.edit-customer').click(async function (e) {
			// declare customer id (token)
			const customerToken = $(this).attr('data-token');
			// fetch one customer by id 
			const customerJson = await fetchData(`${apiUrl}/customer/get_one.php`, { customerToken }, 'POST');

			const renderResult = await render({customerJson,form:'edit'}, 'form.html');
			$('.modal-content').html(renderResult);
			$('.modal').modal('open');

			$('#customer_form_edit').submit(async function (e) {
				e.preventDefault();
				const data = serializeData($('#customer_form_edit'))

				data.customerToken = customerJson.customer_token;
				data.customer_phone1 = customerJson.customer_phone1;
				const { customer_name, customer_email, customerToken } = await fetchData(`${apiUrl}/customer/update_customer.php`, data, 'POST');
				const userDiv = $(`[data-token=${customerToken}] p`)

				userDiv.html(`<p> ${customer_name}<br>Email: ${customer_email}</p>`);
				$('.modal').modal('close');
			})

		})
		$('.add-customer').click(async function (e) {
			const business_token = $(this).attr('data-token');
			const renderResult = await render({ business_token,form:'add' }, 'form.html');
			$('.modal-content').html(renderResult);
			$('.modal').modal('open');

			$('#customer_form_add').submit(async function (e) {
				e.preventDefault();
				const data = serializeData($('#customer_form_add'))

				data.businessToken = business_token;
				const customer_token = await fetchData(`${apiUrl}/customer/add_customer.php`, data, 'POST');

				$('#customers').prepend(` 
					<li data-token="${customer_token}" class="collection-item">
						<p>${data.customer_name} <br>Email: ${data.customer_email}</p>
						<span data-token="${customer_token}" class="secondary-content edit-customer"><i class="material-icons">edit</i></span>
					</li> `);

				$('.modal').modal('close');
			})
		})
		$('.is-active').change(function () {
			const businessToken = $(this).attr('data-token');
			const data = { businessToken }
			console.log(data);

			let labelText = '';
			if ($(this).prop("checked")) {
				// checked

				data.operation = "activate"
				labelText = "Deactivate"

				fetchData(`${apiUrl}/business/change_activity.php`, data, 'POST')

			} else {
				// not checked
				labelText = "Activate"
				data.operation = "deactivate"
				fetchData(`${apiUrl}/business/change_activity.php`, data, 'POST')

			}
			$(this).next().text(labelText)
			return
		});
	})

});
$(window).on('resize', function () {
	screenSizeHandler();
});
