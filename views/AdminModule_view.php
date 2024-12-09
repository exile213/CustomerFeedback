<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <style>
        @keyframes float {
            0% { transform: translateY(0) rotate(-25deg); }
            50% { transform: translateY(-20px) rotate(-25deg); }
            100% { transform: translateY(0) rotate(-25deg); }
        }

        @keyframes reveal {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom right, #4338ca, #7e22ce, #ec4899);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .shapes {
            position: absolute;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 156, 118, 0.4);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            transform: rotate(-25deg);
        }

        .shape-1 {
            height: 150px;
            width: 150px;
            top: 20%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            height: 100px;
            width: 100px;
            top: 60%;
            left: 30%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-3 {
            height: 200px;
            width: 200px;
            top: 40%;
            left: 50%;
            animation: float 7s ease-in-out infinite;
        }

        .container {
            text-align: center;
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
        h1 {
            color: #811ed5;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.8);
            border: 1px white solid;
            border-radius: 1rem;
            margin-bottom: 2rem;
            animation: reveal 0.8s ease-out;
            font-size: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            display: flex;
            flex-direction: row;
            gap: 1rem;
        }

        .button {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s, border-color 0.3s;
            animation: reveal 0.8s ease-out;
            backdrop-filter: blur(5px);
        }

        .button:nth-child(2) { animation-delay: 0.1s; }
        .button:nth-child(3) { animation-delay: 0.2s; }

        .button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
        }



    </style>
</head>
<body>
<div class="shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
</div>
<div class="container">
    <h1>Which interface would you like to access?</h1>
    <div class="button-container">
        <a class="button">Inventory</a>
        <a class="button">Point-of-Sale</a>
        <a class="button">CRM</a>
    </div>
</div>
</body>
</html>

