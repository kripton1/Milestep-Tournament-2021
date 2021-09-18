<?php

if(!isset($_COOKIE['__cdr']) || $_COOKIE['__cdr'] != 'true'){
	header('Location: /application/login.php');
}

$title = 'Календарь';

$year = $_GET['time'] ? date('Y', $_GET['time']) : date('Y');
$month = $_GET['time'] ? date('n', $_GET['time']) : date('n');
include_once './db.php';

ob_start();
?>

<div class="row mt-4">
	<div class="col-md-1"></div>
	<div class="col">
		<form class="row mb-4 data-control">
		 	<div class="col-3">
		 		<label for="year" class="form-label">Год</label>
		    	<input type="text" class="form-control" name="year" id="year" placeholder="Год" aria-label="Год" value="<?=$year?>">
		  	</div>
		  	<div class="col-3">
		  		<label for="month" class="form-label">Месяц</label>
		    	<input type="text" class="form-control" name="month" id="month" placeholder="Месяц" aria-label="Месяц" value="<?=$month?>">
		  	</div>
		  	<div class="col-3 mt-4">
		    	<input type="submit" class="btn btn-outline-light mt-1" value="&#128269;">
		  	</div>
		</form>

		<table class="table table-light table-bordered border-warning rounded">
			<thead>
				<tr>
				  	<th scope="col">ПН</th>
				  	<th scope="col">ВТ</th>
				  	<th scope="col">СР</th>
				  	<th scope="col">ЧТ</th>
				  	<th scope="col">ПТ</th>
				  	<th scope="col">СБ</th>
				  	<th scope="col">ВС</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$j = 1; 
					$date = isset($_GET['time']) ? date('t', $_GET['time']) : date('t');
					for($i = 1; $i < $date; $i++){ 
				?>
				<tr>
				  	<?php if($i < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				  	<?php if($i++ < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				  	<?php if($i++ < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				  	<?php if($i++ < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				  	<?php if($i++ < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				  	<?php if($i++ < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				  	<?php if($i++ < $date){ ?> <td><?=$i?></td> <?php }else{ ?> <td class="text-muted"><?=$j++?></td> <?php } ?>
				</tr>
				<?php }
				if($date < 29){
				?>
				<tr>
					<td class="text-muted">1</td>
					<td class="text-muted">2</td>
					<td class="text-muted">3</td>
					<td class="text-muted">4</td>
					<td class="text-muted">5</td>
					<td class="text-muted">6</td>
					<td class="text-muted">7</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-1"></div>
</div>


<button type="hidden" style="display: none;" class="btn btn-primary modal-day-open" data-bs-toggle="modal" data-bs-target="#dayModal"></button>

<div class="modal fade" id="dayModal" tabindex="-1" aria-labelledby="dayModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
	  		<div class="modal-header">
	    		<h5 class="modal-title" id="dayModalLabel">События Nго числа</h5>
	    		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  		</div>
	  		<div class="modal-body">
	    		
	  		</div>
	  		<div class="modal-footer">
		        <button type="button" class="btn btn-primary">Добавить событие</button>
		    </div>
		</div>
	</div>
</div>

<button type="hidden" style="display: none;" class="btn btn-primary modal-add-event-open" data-bs-toggle="modal" data-bs-target="#eventModal"></button>

<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
	  		<div class="modal-header">
	    		<h5 class="modal-title" id="eventModalLabel">Добавить событие к Nму числу</h5>
	    		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  		</div>
	  		<div class="modal-body">
	    		<form>
	    			<div class="mb-3">
					  	<label for="title" class="form-label">Название события</label>
					  	<input type="text" class="form-control" id="title" name="title">
					</div>
					<div class="mb-3">
					  	<label for="describtion" class="form-label">Описание события</label>
					  	<input type="text" class="form-control" id="describtion" name="describtion">
					</div>
	    		</form>
	  		</div>
	  		<div class="modal-footer">
		        <button type="button" class="btn btn-primary">Добавить</button>
		    </div>
		</div>
	</div>
</div>


<?php
$body = ob_get_contents();
ob_end_clean();

require_once 'render.php';
?>