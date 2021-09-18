// https://stackoverflow.com/questions/5448545/how-to-retrieve-get-parameters-from-javascript
function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

// смена дней месяца после отправки timestamp
document.querySelector('form.data-control').onsubmit = (e)=>{
	e.preventDefault();
	let year = document.querySelector('form.data-control input[name="year"]').value;
	let month = document.querySelector('form.data-control input[name="month"]').value;
	month -= 1;
	let date = new Date(year, month);
	window.location.href="/home.php?time="+Math.floor(date.getTime() / 1000);
}

// при нажатии на день в календаре
let tds = document.querySelectorAll('table.table tbody tr td:not(.text-muted)');
for(let i = 0; i < tds.length; i++){
	tds[i].onclick = (e)=>{
		let day = e.currentTarget.innerText;
		window.location.hash = day;
		document.querySelector('button.modal-day-open').click();
		document.querySelector('div.modal#dayModal div.modal-header h5').innerText = 'События '+day+'го числа';
		let htmlBody = '';
		// получить события текушего дня
		$.post('./db.php', {jquery: true, method: 'getEvents', time: findGetParameter('time'), day: day}, (data)=>{
			if(data == '[]'){
				htmlBody = '<p class="h4">Нет событий на эту дату</p>';
			}else{
				data = JSON.parse(data);
				for(let i = 0; i < data.length; i++){
					htmlBody += `<div class="col" id="event-`+data[i].id+`">
		    			<p>`+data[i].title+`</p>
		    			<p class="small text-muted">`+data[i].describtion+`</p>
		    			<div class="col-right">
		    				<button type="button" style="margin-bottom: -7px" class="btn">&#128395;</button>
		    				<button type="button" class="btn-close"></button>
		    			</div>
		    		</div>`;
				}
			}
			document.querySelector('div.modal#dayModal div.modal-body').innerHTML = htmlBody;

			// удалить событие по нажатию на крестик возле него
			let closes = document.querySelectorAll('div.modal#dayModal div.modal-body div.col div.col-right button.btn-close');
			let edits = document.querySelectorAll('div.modal#dayModal div.modal-body div.col div.col-right button.btn');
			for(let i = 0; i < closes.length; i++){
				closes[i].onclick = (e)=>{
					let close = e.currentTarget;
					console.log(close.parentNode.parentNode.id.split('-')[1]);
					$.post('./db.php', {jquery: true, method: 'deleteEvent', id: close.parentNode.parentNode.id.split('-')[1]}, (data)=>{
						if(data == 'true'){
							$(close.parentNode.parentNode).remove();
						}else{
							console.error(data);
						}
					});
				}

				edits[i].onclick = (e)=>{
					document.querySelector('div.modal#dayModal div.modal-header button.btn-close').click();
					document.querySelector('button.modal-add-event-open').click();
					document.querySelector('div.modal#eventModal div.modal-header h5').innerText = 'Редактировать событие к '+day+'му числу';
					document.querySelector('div.modal#eventModal div.modal-footer button').innerText = 'Сохранить';
					document.querySelector('div.modal#eventModal div.modal-body input#title').value = edits[i].parentNode.parentNode.childNodes[1].innerText;
					document.querySelector('div.modal#eventModal div.modal-body input#describtion').value = edits[i].parentNode.parentNode.childNodes[3].innerText;
					// при нажатии "Сохранить"
					$("div.modal#eventModal div.modal-footer button").on('click', (e)=>{
						e.preventDefault();
						let title = document.querySelector('div.modal#eventModal div.modal-body input#title').value;
						let desc = document.querySelector('div.modal#eventModal div.modal-body input#describtion').value;
						$("div.modal#eventModal div.modal-footer button").off('click');
						$.post('./db.php', {jquery: true, method: 'editEvent', title: title, describtion: desc, id: edits[i].parentNode.parentNode.id.split('-')[1]}, (data)=>{
							if(data == 'true'){
								document.querySelector('div.modal#eventModal div.modal-footer button').value = 'Добавить';
								document.querySelector('div.modal#eventModal div.modal-body input#title').value = '';
								document.querySelector('div.modal#eventModal div.modal-body input#describtion').value = '';
								document.querySelector('div.modal#eventModal div.modal-header button.btn-close').click();
							}else{
								console.error(data);
							}
						});
					});
				}
			}
		})
	}
}

// при нажатии на "Добавить событие"
document.querySelector('div.modal#dayModal div.modal-footer button').onclick = (e)=>{
	e.preventDefault();
	let day = window.location.hash.slice(1);
	document.querySelector('div.modal#dayModal div.modal-header button.btn-close').click();
	document.querySelector('button.modal-add-event-open').click();
	document.querySelector('div.modal#eventModal div.modal-header h5').innerText = 'Добавить событие к '+day+'му числу';
	// при нажатии "Добавить"
	$("div.modal#eventModal div.modal-footer button").on('click', (e)=>{
		e.preventDefault();
		let title = document.querySelector('div.modal#eventModal div.modal-body input#title').value;
		let desc = document.querySelector('div.modal#eventModal div.modal-body input#describtion').value;
		$("div.modal#eventModal div.modal-footer button").off('click');
		$.post('./db.php', {jquery: true, method: 'addEvent', title: title, describtion: desc, time: findGetParameter('time'), day: day}, (data)=>{
			if(data == 'true'){
				document.querySelector('div.modal#eventModal div.modal-body input#title').value = '';
				document.querySelector('div.modal#eventModal div.modal-body input#describtion').value = '';
				document.querySelector('div.modal#eventModal div.modal-header button.btn-close').click();
			}else{
				console.error(data);
			}
		});
	});
}

// при нажатии на иконку редактирования события
document.querySelector('div.modal#dayModal div.modal-footer button').onclick = (e)=>{
	e.preventDefault();
	let day = window.location.hash.slice(1);
	
}