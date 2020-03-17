
async function render(jsonFile, templateFile) {
	const template = await fetchData(templateFile)
	return Mustache.render(template, jsonFile);

}

function screenSizeHandler() {
	if ($(window).width() <= 1100) {
		$('#meta-height').attr('content', 'width=1100, initial-scale=1.0');
	} else {
		$('#meta-height').attr('content', 'width=device-width, initial-scale=1.0');
	}
}

async function fetchData(url, data = {}, method = 'GET') {

	try {
		const jsonData = JSON.stringify(data);
		let response = await $.ajax({ url, method, data:jsonData  })
		return response;
	} catch (err) {
		console.error('fetchData -> err', err);
		return {};
	}

}

function formatDate(userDate) {
	// format from M/D/YYYY to YYYYMMDD
	return new Date(userDate).toJSON().slice(0, 10).split('-').reverse().join('-');
}
function serializeData(form){
	const formdata = form.serializeArray();
	const data = {};
	$(formdata).each(function (index, obj) {
		data[obj.name] = obj.value;
	});
	return data;
}
