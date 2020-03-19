export async function customerFormRender(url, token, $hostElement, templateFile) {
	console.log('customerFormRender -> token', token);
	let mainObj = {};

	const customerJson = await fetchData(`${url}/customer/get_one.php`, { customerToken: token }, 'POST');

	if (customerJson.length) {
		// fetch one customer by id
	} else {
		mainObj.error = 'Failed to fetch data';
	}

	const renderResult = await render({ customerJson, form: 'edit' }, templateFile);
	// implement html to main div
	$hostElement.html(renderResult);
}
