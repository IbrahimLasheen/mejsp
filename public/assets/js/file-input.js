$(document).ready(function(){function e(e="#input-image",t=".view-image"){$(e).change(function(e){e.preventDefault();let n=URL.createObjectURL(e.currentTarget.files[0]);$(t).attr("src",n)})}e()});