<style type="text/css">
	.ps_post_sharing_container{
		display: inline-block;
		position: fixed;
		bottom: 30px;
		right: 10px;
		z-index: 100;
		overflow: hidden;
		transition: 0.1s linear;
	}

	.ps_post_sharing_container:hover{
		transform: scale(1.1);
	}

	.ps_post_sharing_block{
		font-family: "montserrat",sans-serif;
		position: relative;
		width: 180px;
		background: #a4b0be;
		display: flex;
		height: 38px;
		border-radius: 19px;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		cursor: pointer;
	}

	.ps_post_sharing_block span{
		position: absolute;
		width: 100%;
		height: 100%;
		background: #2d3436;
		color: #dfe6e9;
		text-align: center;
		line-height: 38px;
		z-index: 10;
		border-radius: 19px;
		transition: 0.5s linear;
	}

	.ps_post_sharing_block:hover span{
		transform: translateX(-100%);
		transition-delay: 0.3s;
	}

	.ps_post_sharing_block a{
		flex: 1;
		font-size: 16px;
		color: #2c3e50;
		text-align: center;
		transform: translateX(-100%);
		opacity: 0;
		transition: 0.3s linear;
	}

	.ps_post_sharing_block:hover a{
		opacity: 1;
		transform: translateX(0);
		transition-delay: 0.6s;
	}
</style>