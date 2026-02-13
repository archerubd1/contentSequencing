<form method="post" action="save_settings.php">

<select name="mode">
<option>Standard</option>
<option>Personalized</option>
<option>Engagement-Aware</option>
</select>

<label>Engagement Influence</label>
<input type="range" name="engagement_weight" min="0" max="1" step="0.1">

<label>Enable Reinforcement</label>
<input type="checkbox" name="rl_enabled" value="1">

<input type="hidden" name="course_id" value="1">

<button>Save</button>

</form>
