<?php $body_class = 'list'; ?>
<?php include_once '_header.php'; ?>
<?php include_once '_nav.php'; ?>
<div class="container">  
	<div class="row header">  
		<div class="span11"><h1>Item Title</h1></div>
		<div class="span1"><a href="edit-posting.php" class="button">Edit</a></div>
	</div>
	<div class="row">  
		<div class="span4">
			<div class="post-image-gallery">
				<div class="main"></div>
				<div class="subs">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
		</div>
		<div class="span8">
			<div class="row">Price: $50.00</div>
			<div class="row"><h3>Item information.</h3> <!-- start slipsum code -->

<p>Fusce a metus eu diam varius congue nec nec sapien. Vestibulum orci tortor, sollicitudin ac euismod non, placerat ac augue. Nunc convallis accumsan justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec malesuada vehicula lectus, viverra sodales ipsum gravida nec. Integer gravida nisi ut magna mollis molestie. Nullam pharetra accumsan sagittis. Proin tristique rhoncus orci, eget vulputate nisi sollicitudin et. Quisque lacus augue, mollis non mollis et, ullamcorper in purus. Morbi et sem orci. Praesent accumsan odio in ante ullamcorper id pellentesque mauris rhoncus. Duis vitae neque dolor. Duis sed purus at eros bibendum cursus nec a nulla. Donec turpis quam, ultricies id pretium sit amet, gravida eget leo.  </p>

<p>Nullam eros mi, mollis in sollicitudin non, tincidunt sed enim. Sed et felis metus, rhoncus ornare nibh. Ut at magna leo. Suspendisse egestas est ac dolor imperdiet pretium. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, erat sit amet venenatis luctus, augue libero ultrices quam, ut congue nisi risus eu purus. Cras semper consectetur elementum. Nulla vel aliquet libero. Vestibulum eget felis nec purus commodo convallis. Aliquam erat volutpat.  </p>

<!-- please do not remove this line -->

<div style="display:none;">
<a href="http://slipsum.com">lorem ipsum</a></div>

<!-- end slipsum code -->
			</div>
			<div class="row"><h3>Poster information</h3>
			<ul>
			<li>Name: Testy McTesterson</li>
			<li>Posted on: 1/12/2013</li>
			</ul>
			<form class="span3">
				<h3>Email poster</h3>
				<input type="text" placeholder="email address" /><br />
				<input type="text" placeholder="phone number" /><br />
				<textarea placeholder="message"></textarea><br />
				<input type="submit" value="send message">
			</form>
			<form class="span3">
				<h3>Send to a friend</h3>
				<input type="text" placeholder="friend's email address" /><br />
				<input type="text" placeholder="your email address" /><br />
				<input type="text" value="I thought you'd be interested in this item on the SCDS community" /><br />
				<textarea placeholder="message"></textarea><br />
				<input type="submit" value="send message">
			</form>
			</div>
		</div>
	</div>
</div>
<?php include_once '_footer.php'; ?>


