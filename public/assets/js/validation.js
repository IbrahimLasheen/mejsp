$(document).ready((function(){$("#form-create-conference").validate({rules:{category:{required:!0},name:{required:!0,maxlength:255}}}),$("#form-create-international-publishing").validate({rules:{type:"required",specialty:"required",journal:"required",file:"required"}}),$("#form-edit-international-publishing").validate({rules:{type:"required",specialty:"required",journal:"required"}}),$("#form-create-users-researches").validate({rules:{type:"required",journal:"required",file:"required",title:"required",abstract:"required"}}),$("#form-edit-users-researches").validate({rules:{type:"required",journal:"required",title:"required",abstract:"required"}}),$("#form-subscribe").validate({rules:{email:{required:!0,email:!0}}})}));