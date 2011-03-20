var t = setInterval("progressRequest()", 4000);
function progressRequest() {
	$.get('/statusAjax.php', function(data) {
		$(data).find("video").each(function() {
			var currentVideo = $(this);
			var videoid = currentVideo.find("id").text();
			var currentRow = $("tr#"+videoid);
			if (currentRow.length != 0) {
				currentRow.html("");
				var currentHTML = "<td>"+currentVideo.find("filename").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("videoprogress").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("videoeta").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("audioprogress").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("muxprogress").text()+"</td>"
				if(currentVideo.find("muxprogress").text() == "Ended") {
					currentHTML += "<td><a href='"+currentVideo.find("encoded").text()+"'>Download</a></td>";
				} else {
					currentHTML += "<td>Wait...</td>";
				}
				currentRow.html(currentHTML);
			} else {
				$("table").append("<tr id='"+videoid+"'></tr>");
				var currentRow = $("tr#"+videoid);
				currentRow.html("");
				var currentHTML = "<td>"+currentVideo.find("filename").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("videoprogress").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("videoeta").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("audioprogress").text()+"</td>";
				currentHTML += "<td>"+currentVideo.find("muxprogress").text()+"</td>"
				if(currentVideo.find("muxprogress").text() == "Ended") {
					currentHTML += "<td><a href='"+currentVideo.find("encoded").text()+"'>Download</a></td>";
				} else {
					currentHTML += "<td>Wait...</td>";
				}
				currentRow.html(currentHTML);
			}
		});
	});
}