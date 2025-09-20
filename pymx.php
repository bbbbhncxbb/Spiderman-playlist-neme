<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MX Player URL Processor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 800px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .header p {
            color: #666;
            font-size: 1.1em;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        input[type="url"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        input[type="url"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }
        
        .result h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .result pre {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
            position: relative;
            user-select: all;
            cursor: text;
        }
        
        .copy-container {
            position: relative;
            margin-top: 10px;
        }
        
        .copy-btn {
            position: absolute;
            top: -45px;
            right: 10px;
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .copy-btn:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }
        
        .copy-btn:active {
            transform: translateY(0);
        }
        
        .copy-btn.copied {
            background: #38a169;
        }
        
        .copy-feedback {
            position: absolute;
            top: -75px;
            right: 10px;
            background: #38a169;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        
        .copy-feedback.show {
            opacity: 1;
        }
        
        .error {
            background: #fed7d7;
            border-left-color: #e53e3e;
            color: #c53030;
        }
        
        .success {
            background: #c6f6d5;
            border-left-color: #38a169;
            color: #2f855a;
        }
        
        .result-info {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .show-info {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .thumbnail {
            width: 200px;
            height: 130px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border: 2px solid #e2e8f0;
            transition: transform 0.3s ease;
        }
        
        .thumbnail:hover {
            transform: scale(1.05);
        }
        
        .show-details {
            flex: 1;
        }
        
        .show-details h4 {
            color: #2d3748;
            font-size: 1.4em;
            margin-bottom: 12px;
            font-weight: 700;
            line-height: 1.3;
        }
        
        .show-details p {
            color: #4a5568;
            font-size: 0.95em;
            margin: 8px 0;
            padding: 6px 12px;
            background: #f7fafc;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }
        
        .show-details p strong {
            color: #2d3748;
            font-weight: 600;
        }
        
        .urls-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
        }
        
        .urls-section h5 {
            color: #2d3748;
            font-size: 1.1em;
            margin-bottom: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .url-item {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 12px;
            border-left: 4px solid #667eea;
            font-size: 0.9em;
            word-break: break-all;
            color: #4a5568;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        
        .url-item:hover {
            transform: translateX(5px);
        }
        
        .url-item strong {
            color: #2d3748;
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .command-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
        }
        
        .command-section h5 {
            color: #2d3748;
            font-size: 1.1em;
            margin-bottom: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        
        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .example {
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .show-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .thumbnail {
                width: 100%;
                max-width: 300px;
                height: auto;
            }
            
            .container {
                padding: 20px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎬 MX Player Processor</h1>
            <p>Extract and process MX Player URLs</p>
        </div>
        
        <form method="POST" id="urlForm">
            <div class="form-group">
                <label for="input_url">MX Player URL:</label>
                <input 
                    type="url" 
                    id="input_url" 
                    name="input_url" 
                    placeholder="https://www.mxplayer.in/show/watch-hip-hop-india/season-2/..."
                    required
                    value="<?php echo isset($_POST['input_url']) ? htmlspecialchars($_POST['input_url']) : ''; ?>"
                >
                <div class="example">
                    Example: https://www.mxplayer.in/show/watch-hip-hop-india/season-2/race-for-the-third-finalist-online-b93a3e7346105047bb120262a65dbaf7?watch=true
                </div>
            </div>
            
            <button type="submit" class="submit-btn" id="submitBtn">
                🚀 Process URL
            </button>
        </form>
        
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Processing URL... Please wait</p>
        </div>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input_url'])) {
            $input_url = trim($_POST['input_url']);
            
            if (!empty($input_url)) {
                echo '<div class="result">';
                echo '<h3>🔄 Processing Result:</h3>';
                
                // Call the process_mx function
                $result = process_mx($input_url);
                
                if ($result !== null && is_array($result)) {
                    echo '<div class="success">';
                    echo '<strong>✅ Success!</strong><br><br>';
                    
                    // Display show information with thumbnail
                    echo '<div class="result-info">';
                    echo '<div class="show-info">';
                    echo '<img src="' . htmlspecialchars($result['thumbnail']) . '" alt="Show Thumbnail" class="thumbnail" onerror="this.style.display=\'none\'">';
                    echo '<div class="show-details">';
                    echo '<h4>📺 ' . htmlspecialchars($result['title']) . '</h4>';
                    echo '<p><strong>🆔 Season ID:</strong> ' . htmlspecialchars($result['season_id']) . '</p>';
                    echo '<p><strong>🔗 URL ID:</strong> ' . htmlspecialchars($result['url_id']) . '</p>';
                    echo '<p><strong>📱 Format:</strong> MKV (High Quality)</p>';
                    echo '</div>';
                    echo '</div>';
                    
                    // Display URLs section
                    echo '<div class="urls-section">';
                    echo '<h5>🔗 Extracted URLs:</h5>';
                    echo '<div class="url-item">';
                    echo '<strong>🖼️ Thumbnail URL:</strong><br>';
                    echo htmlspecialchars($result['thumbnail']);
                    echo '</div>';
                    echo '<div class="url-item">';
                    echo '<strong>🎥 DASH Stream URL:</strong><br>';
                    echo htmlspecialchars($result['dash_url']);
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    // Display the download command
                    echo '<div class="command-section">';
                    echo '<h5>💻 Download Command:</h5>';
                    echo '<div class="copy-container">';
                    echo '<button class="copy-btn" onclick="copyToClipboard(this)">📋 Copy Command</button>';
                    echo '<div class="copy-feedback">Copied!</div>';
                    echo '<pre id="result-command">' . htmlspecialchars($result['command']) . '</pre>';
                    echo '</div>';
                    echo '</div>';
                    
                    echo '</div>';
                } else {
                    echo '<div class="error">';
                    echo '<strong>❌ Error:</strong> Failed to process the URL. Please check the URL and try again.';
                    echo '</div>';
                }
                
                echo '</div>';
            }
        }
        
        function process_mx($input_url) {
            // Extract the formatted URL
            $f_url = str_replace("https://www.mxplayer.in", "", $input_url);
            
            // Split by "?" to remove query parameters, then split by "-" to get the last part
            $url_parts = explode("?", $f_url);
            $url_without_params = $url_parts[0];
            $url_segments = explode("-", $url_without_params);
            $urlid = end($url_segments);
            
            try {
                // Make first API request
                $api_url = "https://seo.mxplay.com/v1/api/seo/get-url-details";
                $params = [
                    "url" => $f_url,
                    "device-density" => "3",
                    "userid" => "2114742f-1adc-4c3d-8e94-dac97b674ae5",
                    "platform" => "com.mxplay.mobile",
                    "content-languages" => "hi,en",
                    "kids-mode-enabled" => "false"
                ];
                
                $query_string = http_build_query($params);
                $full_url = $api_url . "?" . $query_string;
                
                $response = file_get_contents($full_url);
                
                if ($response === false) {
                    throw new Exception("Failed to fetch first API response");
                }
                
                $first = json_decode($response, true);
                
                if (!$first) {
                    throw new Exception("Failed to decode first API response JSON");
                }
                
                // Extract required information
                $season_id = $first["data"]["dependencies"]["season"]["id"];
                $display_title = str_replace("|", "", $first["data"]["display_title"]);
                
                // Prepare headers for second API request
                $headers = [
                    'authority: api.mxplayer.in',
                    'accept: application/json, text/plain, */*',
                    'accept-language: en-GB,en-US;q=0.9,en;q=0.8',
                    'cookie: platform=com.mxplay.mobile; UserID=2114742f-1adc-4c3d-8e94-dac97b674ae5; languageDismissed=false; Content-Languages=hi,en',
                    'origin: https://www.mxplayer.in',
                    'referer: https://www.mxplayer.in/',
                    'sec-ch-ua: "Chromium";v="111", "Not(A:Brand";v="8"',
                    'sec-ch-ua-mobile: ?1',
                    'sec-ch-ua-platform: "Android"',
                    'sec-fetch-dest: empty',
                    'sec-fetch-mode: cors',
                    'sec-fetch-site: same-site',
                    'user-agent: Mozilla/5.0 (Linux; Android 11; M2101K6P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Mobile Safari/537.36'
                ];
                
                $last_api_url = 'https://api.mxplayer.in/v1/web/detail/tab/aroundcurrentepisodes';
                $last_params = [
                    'type' => 'season',
                    'id' => $season_id,
                    'filterId' => $urlid,
                    'device-density' => '3',
                    'userid' => '2114742f-1adc-4c3d-8e94-dac97b674ae5',
                    'platform' => 'com.mxplay.mobile',
                    'content-languages' => 'hi,en',
                    'kids-mode-enabled' => 'false'
                ];
                
                $last_query_string = http_build_query($last_params);
                $last_full_url = $last_api_url . "?" . $last_query_string;
                
                // Use cURL for the second request to include headers
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $last_full_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                
                $last_response = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($last_response === false || $http_code !== 200) {
                    throw new Exception("Failed to fetch second API response. HTTP Code: " . $http_code);
                }
                
                $last_api = json_decode($last_response, true);
                
                if (!$last_api) {
                    throw new Exception("Failed to decode second API response JSON");
                }
                
                // Extract thumbnail and DASH URL
                $base = "https://llvod.mxplay.com/";
                $th = $base . $last_api["items"][0]["imageInfo"][0]["url"];
                $dash = $base . $last_api["items"][0]["stream"]["mxplay"]["dash"]["high"];
                
                // Format is always 'mkv' as requested
                $format_value = 'mkv';
                
                $YYDLP = '/m3u8p |./N_m3u8DL-RE "' . $th . '" "' . $dash . '" ' .
                        '--header "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36" ' .
                        '--append-url-params --check-segments-count=false -mt -M format=' . $format_value . ' --thread-count 64 -sv best ' .
                        '-sa best --save-name "' . $display_title . '"|';
                
                // Return both the command and the show information
                return [
                    'command' => $YYDLP,
                    'title' => $display_title,
                    'thumbnail' => $th,
                    'dash_url' => $dash,
                    'season_id' => $season_id,
                    'url_id' => $urlid
                ];
                
            } catch (Exception $e) {
                error_log("MX Player Processing Error: " . $e->getMessage());
                return null;
            }
        }
        ?>
    </div>
    
    <script>
        document.getElementById('urlForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const loading = document.getElementById('loading');
            
            submitBtn.style.display = 'none';
            loading.style.display = 'block';
            
            // Form will submit normally, this just shows loading state
        });
        
        // Auto-focus on the input field
        document.getElementById('input_url').focus();
        
        // Copy to clipboard function
        function copyToClipboard(button) {
            const preElement = button.parentElement.querySelector('pre');
            const text = preElement.textContent;
            
            // Try using the modern clipboard API first
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopyFeedback(button);
                }).catch(err => {
                    fallbackCopyTextToClipboard(text, button);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(text, button);
            }
        }
        
        function fallbackCopyTextToClipboard(text, button) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            
            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";
            
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopyFeedback(button);
                }
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }
            
            document.body.removeChild(textArea);
        }
        
        function showCopyFeedback(button) {
            const feedback = button.parentElement.querySelector('.copy-feedback');
            
            // Show feedback
            feedback.classList.add('show');
            button.classList.add('copied');
            button.textContent = '✅ Copied!';
            
            // Reset after 2 seconds
            setTimeout(() => {
                feedback.classList.remove('show');
                button.classList.remove('copied');
                button.textContent = '📋 Copy Command';
            }, 2000);
        }
        
        // Allow selecting text in pre elements by clicking
        document.addEventListener('DOMContentLoaded', function() {
            const preElements = document.querySelectorAll('pre');
            preElements.forEach(pre => {
                pre.addEventListener('click', function() {
                    const selection = window.getSelection();
                    const range = document.createRange();
                    range.selectNodeContents(this);
                    selection.removeAllRanges();
                    selection.addRange(range);
                });
            });
        });
    </script>
</body>
</html>