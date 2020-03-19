export async function singleBusinessRender(url, token, $hostElement, templatFile) {
	console.log('singleBusinessRender -> token', token);
	let mainObj = {};

	const businessJson = await fetchData(`${url}/business/get_one.php`, { businessToken: token }, 'POST');
	console.log('singleBusinessRender -> businessJson', businessJson);
	let customersJson = await fetchData(`${url}/customer/get_all.php`, { businessToken: token }, 'POST');
	console.log('singleBusinessRender -> customersJson', customersJson);

	if (businessJson.length && customersJson.length) {
		// map on list and add some new values
		// add more values to business object
		businessJson.isActive = businessJson.businessIsActive === 'Yes';
		businessJson.activeSince = formatDate(businessJson.businessCreationDate);
		businessJson.businessFeatures = businessJson.businessFeatures.map((feature) => {
			feature.isActive = feature.featureActive === 'Yes';
			return feature;
		});
		mainObj.businessJson = businessJson;
	} else {
		mainObj.error = 'Failed to fetch data';
	}
	console.log('singleBusinessRender -> mainObj', mainObj);
	// render one business and his list of customers to template
	const renderResult = await render({ businessJson, customersJson }, templatFile);
	// implement html to main div
	$hostElement.html(renderResult);
}
