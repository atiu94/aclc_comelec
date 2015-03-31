
# ACLC COMELEC Voting System  
**Version:** 1.0  
**Date:** March 2015  
**Author:** [Eyana Mallari](http://about.me/eyana.m)  
<center>
![System Screenshot](/fig/screenshot.png)
</center>


## General Use Case  
1. Add Candidates.  
![System Screenshot](/fig/add_candidate.png)  
2. Set Eligibility. Determine if a candidate is called or not called.   
![System Screenshot](/fig/called.png)  
3. Cast Votes  
![System Screenshot](/fig/cast_votes.png)  
4. See Results 
![System Screenshot](/fig/voting_results.png)  
5. Reset Votes for Next Round. 
![System Screenshot](/fig/reset_votes.png)  
6. Reset Vote Limit in  

`views/admin/votes/create.php` line 60

```javascript
var limit = 2; //set vote limit here
$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > limit) {
        $(this).prop('checked', false);
        alert("You are only allowed to vote for "+limit+" candidates.");
    }
});
```

`controller/admin/votes.php` line 50  

```php
public function create()
{
	$this->template->title('Cast Vote');

	if($this->input->post('submit'))
	{
		$can_ids = $this->input->post('can_ids');
		$can_ids_count = count($can_ids);

		if($can_ids !== false)
		{
			$limit = 2; //set limit here
			if($can_ids_count >= $limit)
			{
				
				foreach($can_ids as $can_id)
				{
```

`controller/admin/candidates.php` line 58 

```php
public function results()
{
...
	$vote_count = $page['vote_count'];
	//hardcoded
	$limit = 2; //set limit here
	$page['voters_count'] = $vote_count/$limit;

```


