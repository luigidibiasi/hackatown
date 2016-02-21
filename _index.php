<style scoped>
#idiv
{
	background-image:url('./background.png');
	background-size:100% 100%;
	position:fixed;
	top:0;
	left:0;
	width:100%;
	height:100%;
	background-color:white;
}
.btn
{
	position:relative;
	top:55%;
	left:22%;
	display:inline-block;
	margin-right:100px;
	padding:30px;
	border:solid 1px #000;
	background-color:#00aa00;
	color:white;
	box-shadow:0 0 5px #000;
	border-radius:10px;
	cursor:pointer;
}
.btn:hover
{
	box-shadow:0 0 10px #f00;
}
</style>
<div id="idiv">
	<div class="btn">Discovery what's happening near you</div>
	<div onclick="location.href='post.php'" class="btn">Push your news in the Knowledge</div>
</div>
