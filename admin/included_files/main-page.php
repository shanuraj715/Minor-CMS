<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/main-page_functions.php'; ?>
<?php

pageForUser('admin');

?>
<?php getActivecards(); ?>
<?php getActivecards_2(); ?>
<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Dashboard";
</script>
<div class="members_activity_container">
	<div class="members_activity_title_block">
		<p class="mem_ac_tit"><i class="fas fa-users-cog"></i> Members Activity</p>
		<p class="mem_ac_desc">Members Performance / Weekly Status</p>
	</div>
	<div class="members_activity_data_container">
		<table>
			<tr>
				<th class="member_image">Member</th>
				<th class="member_name">Name</th>
				<th class="member_post_num">Posts</th>
				<th class="member_reviews">Ratings</th>
			</tr>

			
			<tr class="members_table_row_data">
				<td>
					<img src="../images/users/user1.png" class="member_img">
				</td>
				<td class="member_name_data">Shanu Raj</td>
				<td>3</td>
				<td>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star-half-alt rating_star"></i>
					<i class="far fa-star rating_star"></i>
				</td>
			</tr>

			
			<tr class="members_table_row_data">
				<td>
					<img src="../images/users/user1.png" class="member_img">
				</td>
				<td class="member_name_data">Diksha Bajaj</td>
				<td>2</td>
				<td>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
				</td>
			</tr>

			
			<tr class="members_table_row_data">
				<td>
					<img src="../images/users/user1.png" class="member_img">
				</td>
				<td class="member_name_data">Rahul Kumar</td>
				<td>4</td>
				<td>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="far fa-star rating_star"></i>
					<i class="far fa-star rating_star"></i>
				</td>
			</tr>

			
			<tr class="members_table_row_data">
				<td>
					<img src="../images/users/user1.png" class="member_img">
				</td>
				<td class="member_name_data">Diksha Bajaj</td>
				<td>3</td>
				<td>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star-half-alt rating_star"></i>
					<i class="far fa-star rating_star"></i>
				</td>
			</tr>

			
			<tr class="members_table_row_data">
				<td>
					<img src="../images/users/user1.png" class="member_img">
				</td>
				<td class="member_name_data">Pratik Thakur</td>
				<td>3</td>
				<td>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star rating_star"></i>
					<i class="fas fa-star-half-alt rating_star"></i>
					<i class="far fa-star rating_star"></i>
				</td>
			</tr>
		</table>
	</div>
</div>











<div class="members_activity_container">
	<div class="members_activity_title_block">
		<p class="mem_ac_tit"><i class="fas fa-cubes"></i> Recent Updates</p>
	</div>
	<div class="members_activity_data_container">
		<table>
			<tr>
				<th id="recent_changes_member" class="recent_changes_user">Member</th>
				<th class="recent_changes_desc" id="recent_changes_member">Desc</th>
				<th class="recent_changes_when">When</th>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Shanu Raj</td>
				<td class="recent_changes_desc">Created a new post.</td>
				<td class="recent_changes_when">7 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Shanu Raj</td>
				<td class="recent_changes_desc">New comment on a post.</td>
				<td class="recent_changes_when">7 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Diksha Bajaj</td>
				<td class="recent_changes_desc">New comment on a post.</td>
				<td class="recent_changes_when">8 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Pratik Thakur</td>
				<td class="recent_changes_desc">Created a new post.</td>
				<td class="recent_changes_when">10 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Pratik Thakur</td>
				<td class="recent_changes_desc">New comment on a post.</td>
				<td class="recent_changes_when">12 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Rahul Kumar</td>
				<td class="recent_changes_desc">New comment on a post.</td>
				<td class="recent_changes_when">17 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Shanu Raj</td>
				<td class="recent_changes_desc">New comment on a post.</td>
				<td class="recent_changes_when">17 Days ago</td>
			</tr>


			<tr class="members_table_row_data">
				<td id="recent_changes_member">Diksha Bajaj</td>
				<td class="recent_changes_desc">New comment on a post.</td>
				<td class="recent_changes_when">18 Days ago</td>
			</tr>


		</table>
	</div>
</div>
























