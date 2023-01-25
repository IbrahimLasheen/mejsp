$(document).ready(function () {

    // Article AR + EN
    $("#form-add-article").validate({
        rules: {
            category: "required",
            slug: {
                required: true,
                maxlength: 500
            },
            meta_desc: {
                required: true,
                maxlength: 1500
            },
            title: {
                required: true,
                maxlength: 255
            },
            image: "required",
            content: "required",
        }
    });
    $("#form-edit-article").validate({
        rules: {
            category: "required",
            slug: {
                required: true,
                maxlength: 500
            },
            meta_desc: {
                required: true,
                maxlength: 1500
            },
            title: {
                required: true,
                maxlength: 255
            },
            content: "required",
        }
    });


    // Conference Categories
    $("#form-add-catrgory").validate({
        rules: {
            name: {
                required: true,
                maxlength: 150
            },
            price: {
                required: true,
                maxlength: 8,
                minlength: 2,
                number: true
            },
        }
    });
    $("#form-edit-catrgory").validate({
        rules: {
            name: {
                required: true,
                maxlength: 150
            },
            price: {
                required: true,
                maxlength: 8,
                minlength: 2,
                number: true
            },
        }
    });


    //number: true

    // Journals
    $("#form-add-journal").validate({
        rules: {
            logo: "required",
            cover: "required",
            brief_desc: {
                required: true,
                maxlength: 8000
            },
            name: {
                required: true,
                maxlength: 255
            },
            meta_desc: {
                required: true,
                maxlength: 1500
            },
            impact: {
                maxlength: 60
            },
            issn: {
                maxlength: 60
            },
            country_code: {
                required: true,
                maxlength: 40,
                number: true
            },
            phone: {
                required: true,
                maxlength: 150,
                number: true
            },
            email: {
                required: true,
                maxlength: 150,
                email: true
            },
            address: {
                required: true,
                maxlength: 255,
            },

        }
    });
    $("#form-edit-journal").validate({
        rules: {
            brief_desc: {
                required: true,
                maxlength: 8000
            },
            name: {
                required: true,
                maxlength: 255
            },
            meta_desc: {
                required: true,
                maxlength: 1500
            },
            impact: {
                maxlength: 60
            },
            issn: {
                maxlength: 60
            },
            country_code: {
                required: true,
                maxlength: 40,
                number: true
            },
            phone: {
                required: true,
                maxlength: 150,
                number: true
            },
            email: {
                required: true,
                maxlength: 150,
                email: true
            },
            address: {
                required: true,
                maxlength: 255,
            },
            next_version_name: {
                required: true,
            },

        }
    });

    // journal reseaches
    $("#form-add-journal-reseaches").validate({
        rules: {
            journal: "required",
            version: "required",
            author_name: {
                required: true,
                maxlength: 255
            },
            title: {
                required: true,
                maxlength: 255
            },
            abstract: {
                required: true,
                maxlength: 6000
            },
            price: {
                number: true
            },

        }
    });
    $("#form-edit-journal-reseaches").validate({
        rules: {
            journal: "required",
            version: "required",
            author_name: {
                required: true,
                maxlength: 255
            },
            title: {
                required: true,
                maxlength: 255
            },
            abstract: {
                required: true,
                maxlength: 6000
            },
            price: {
                number: true
            },

        }
    });


    // service
    $("#form-add-service").validate({
        rules: {
            icon: {
                maxlength: 255
            },
            title: {
                required: true,
                maxlength: 255
            },
        }
    });


    // team
    $("#form-add-team").validate({
        rules: {
            name: {
                required: true,
                maxlength: 150
            },
            job: {
                required: true,
                maxlength: 150
            },
            image: "required",
        }
    });
    $("#form-edit-team").validate({
        rules: {
            name: {
                required: true,
                maxlength: 150
            },
            job: {
                required: true,
                maxlength: 150
            },
        }
    });


    // International Publishing Journals
    $("#form-add-international-publishing-journals").validate({
        rules: {
            type: "required",
            specialty: "required",
            name: {
                required: true,
                maxlength: 1500
            },
            price: {
                required: true,
                number: true
            },
        }
    });




















    $("#form-edit-service").validate({
        rules: {
            slug: {
                required: true,
                maxlength: 500
            },
            meta_desc: {
                required: true,
                maxlength: 1500
            },
            title: {
                required: true,
                maxlength: 255
            },
            content: "required",
        }
    });
    // library category
    $("#form-add-library-category").validate({
        rules: {
            title: {
                required: true,
                maxlength: 255
            },
            desc: {
                maxlength: 5000
            },
            image: "required",
        }
    });
    $("#form-edit-library-category").validate({
        rules: {
            title: {
                required: true,
                maxlength: 255
            },
            desc: {
                maxlength: 5000
            },
        }
    });
    // library category
    $("#form-add-library").validate({
        rules: {
            title: {
                required: true,
                maxlength: 1500
            },
            category: "required",
            file: "required",
        }
    });
    $("#form-edit-library").validate({
        rules: {
            title: {
                required: true,
                maxlength: 1500
            },
            category: "required",
        }
    });

    // Projects
    $("#form-add-project").validate({
        rules: {
            price: {
                required: true,
                number: true
            },
            duration: {
                required: true,
                number: true
            },
        }
    });













});