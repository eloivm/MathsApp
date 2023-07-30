<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vista Previa Pregunta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-AMS_CHTML"></script>
    @vite('resources/css/style.css')
    @vite('resources/css/dashboard.css')
    <style>
        .latexOutput {
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            min-height: 38px;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .title-text {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .custom-form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
        }

        .d-flex.justify-content-end.mb-3 {
            margin-top: auto;
            margin-right: 20px;
            margin-bottom: 20px;
            margin-left: 20px;
        }

        .custom-form-check label {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .custom-radio {
            width: 20px;
            height: 20px;
            margin-bottom: 10px;
            border: 2px solid #007bff;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .custom-radio:after {
            content: "";
            display: block;
            width: 12px;
            height: 12px;
            margin: 3px;
            border-radius: 50%;
            background: #007bff;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .custom-form-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
        }

        .form-checks-wrapper {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            margin: 0 20px;
        }

        .custom-form-check {
            flex: 1 0 30%;
            max-width: 30%;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @include('partials.navbar_teacher')
    <div class="container content mt-3">
        <div class="row justify-content-center" style="overflow: auto;">
            <div class="col-md-12">
                <div class="card h-100" style="border-radius: 15px;">
                    <div class="card-body">
                        <form method="POST" action="#" class="d-flex flex-column justify-content-between h-100">
                            <div class="custom-form-wrapper">
                                <div class="form-group custom-form-group">
                                    <label class="title-text mb-3" for="question">{{ $question_text }}</label>
                                    @if((isset($question['question_type']) && $question['question_type'] == 'short_answer'))
                                        <input type="text" class="form-control mb-2 custom-input" id="short_answer" name="short_answer" disabled>
                                    @elseif((isset($question['question_type']) && $question['question_type'] == 'multiple_choice'))
                                        <div class="form-checks-wrapper">
                                            @foreach($question['answers'] as $answer)
                                                <div class="form-check custom-form-check">
                                                    <label class="title-text mb-3">
                                                        <input class="form-check-input" type="radio" name="answer" id="answer{{ $loop->index }}" value="{{ $answer }}" style="display: none;">
                                                        <div class="custom-radio"></div>
                                                        {{ $answer }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-3">
                                <button type="submit" class="btn btn-primary" disabled>Siguiente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
    </script>
</body>
</html>
