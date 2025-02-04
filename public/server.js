const http = require('http');
const childProcess = require('child_process');

http.createServer((req, res) => {
    if (req.url === '/start') {
        childProcess.exec('npm start', (error, stdout, stderr) => {
            if (error) {
                console.error(`exec error: ${error}`);
                return;
            }
            console.log(`stdout: ${stdout}`);
            console.log(`stderr: ${stderr}`);
        });
        res.writeHead(200, { 'Content-Type': 'text/plain' });
        res.end('npm start executed\n');
    } else {
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('Not found\n');
    }
}).listen(3000, () => {
    console.log('Server listening on port 3000');
});