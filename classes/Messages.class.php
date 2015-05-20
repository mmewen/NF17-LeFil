<?php
class Messages {
	private function Messages (){
	}

	public static function info($message){ ?>
		<div class="alert alert-info" role="alert">
		    <?php echo($message); ?>
		</div>
	<?php }

	public static function warn($message){ ?>
		<div class="alert alert-warning" role="alert">
		    <?php echo($message); ?>
		</div>
	<?php }

	public static function error($message){ ?>
		<div class="alert alert-danger" role="alert">
		    <?php echo($message); ?>
		</div>
	<?php }
};