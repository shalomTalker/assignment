export async function mainRender(url, $hostElement, templateFile) {
	let mainObj = {};

	// fetch all customers
	let buisnessListJson = await fetchData(`${url}business/get_all.php`);

	if (buisnessListJson.length) {
		// map on list and add some new values
		buisnessListJson = buisnessListJson.map((buisness) => {
			buisness.isActive = buisness.businessIsActive === 'Yes';
			buisness.activeSince = formatDate(buisness.businessCreationDate);
			return buisness;
		});
		mainObj.buisnessListJson = buisnessListJson;
	} else {
		mainObj.error = 'Failed to fetch data';
	}

	// render list of businesses to template
	const renderResult = await render(mainObj, templateFile);
	// implement html to main div
	return $hostElement.html(renderResult);
}
