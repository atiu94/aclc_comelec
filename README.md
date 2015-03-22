
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
6. Reset Vote Limit in `views/admin/votes/create` line 60

```javascript
var limit = 2; //reset vote limit here
$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > limit) {
        $(this).prop('checked', false);
        alert("You are only allowed to vote for "+limit+" candidates.");
    }
});
```


