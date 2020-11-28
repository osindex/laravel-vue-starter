<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <title>登录界面</title>
        <style>
            html,body{
                margin: 0;padding: 0;
            }
        </style>
    </head>

    <body style="background-image: url('/assets/login/img/bg.png'); background-position: initial initial; background-repeat: initial initial;">
        <div class="OverWindows"></div>

<script type="text/javascript">
  document.write=function() {};
  document.writeln=function() {};
</script>
<script type="text/javascript" src="/assets/login/js/ThreeWebGL.js"></script>
<script type="text/javascript" src="/assets/login/js/ThreeExtras.js"></script>
<script type="text/javascript" src="/assets/login/js/Detector.js"></script>
<script id="vs" type="x-shader/x-vertex">
        varying vec2 vUv;
        void main() {
            vUv = uv;
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }
    </script>
<script id="fs" type="x-shader/x-fragment">
        uniform sampler2D map;
        uniform vec3 fogColor;
        uniform float fogNear;
        uniform float fogFar;
        varying vec2 vUv;
        void main() {
            float depth = gl_FragCoord.z / gl_FragCoord.w;
            float fogFactor = smoothstep(fogNear, fogFar, depth);
            gl_FragColor = texture2D(map, vUv);
            gl_FragColor.w *= pow(gl_FragCoord.z, 20.0);
            gl_FragColor = mix(gl_FragColor, vec4(fogColor, gl_FragColor.w), fogFactor);
        }
    </script>
<script type="text/javascript">
    if(!Detector.webgl) Detector.addGetWebGLMessage();
    var canvas = document.createElement('canvas');
    canvas.width = 32;
    canvas.height = window.innerHeight;
    var context = canvas.getContext('2d');
    var gradient = context.createLinearGradient(0, 0, 0, canvas.height);
    gradient.addColorStop(0, "#1e4877");
    gradient.addColorStop(0.5, "#4584b4");
    context.fillStyle = gradient;
    context.fillRect(0, 0, canvas.width, canvas.height);
    document.body.style.background = 'url(' + canvas.toDataURL('image/png') + ')';
    var container;
    var camera, scene, renderer, sky, mesh, geometry, material, i, h, color, colors = [],
        sprite, size, x, y, z;
    var mouseX = 0,
        mouseY = 0;
    var start_time = new Date().getTime();
    var windowHalfX = window.innerWidth / 2;
    var windowHalfY = window.innerHeight / 2;
    init();
    animate();

    function init() {
        container = document.createElement('div');
        document.body.appendChild(container);
        camera = new THREE.Camera(30, window.innerWidth / window.innerHeight, 1, 3000);
        camera.position.z = 6000;
        scene = new THREE.Scene();
        geometry = new THREE.Geometry();
        var texture = THREE.ImageUtils.loadTexture('/assets/login/img/c.png');
        texture.magFilter = THREE.LinearMipMapLinearFilter;
        texture.minFilter = THREE.LinearMipMapLinearFilter;
        var fog = new THREE.Fog(0x4584b4, -100, 3000);
        material = new THREE.MeshShaderMaterial({
            uniforms: {
                "map": {
                    type: "t",
                    value: 2,
                    texture: texture
                },
                "fogColor": {
                    type: "c",
                    value: fog.color
                },
                "fogNear": {
                    type: "f",
                    value: fog.near
                },
                "fogFar": {
                    type: "f",
                    value: fog.far
                },
            },
            vertexShader: document.getElementById('vs').textContent,
            fragmentShader: document.getElementById('fs').textContent,
            depthTest: false
        });
        var plane = new THREE.Mesh(new THREE.Plane(64, 64));
        for(i = 0; i < 8000; i++) {
            plane.position.x = Math.random() * 1000 - 500;
            plane.position.y = -Math.random() * Math.random() * 200 - 15;
            plane.position.z = i;
            plane.rotation.z = Math.random() * Math.PI;
            plane.scale.x = plane.scale.y = Math.random() * Math.random() * 1.5 + 0.5;
            GeometryUtils.merge(geometry, plane)
        }
        mesh = new THREE.Mesh(geometry, material);
        scene.addObject(mesh);
        mesh = new THREE.Mesh(geometry, material);
        mesh.position.z = -8000;
        scene.addObject(mesh);
        renderer = new THREE.WebGLRenderer({
            antialias: false
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        container.appendChild(renderer.domElement);
        document.addEventListener('mousemove', onDocumentMouseMove, false);
        window.addEventListener('resize', onWindowResize, false)
    }

    function onDocumentMouseMove(event) {
        mouseX = (event.clientX - windowHalfX) * 0.25;
        mouseY = (event.clientY - windowHalfY) * 0.15
    }

    function onWindowResize(event) {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight)
    }

    function animate() {
        requestAnimationFrame(animate);
        render()
    }

    function render() {
        position = ((new Date().getTime() - start_time) * 0.03) % 8000;
        camera.position.x += (mouseX - camera.target.position.x) * 0.01;
        camera.position.y += (-mouseY - camera.target.position.y) * 0.01;
        camera.position.z = -position + 8000;
        camera.target.position.x = camera.position.x;
        camera.target.position.y = camera.position.y;
        camera.target.position.z = camera.position.z - 1000;
        renderer.render(scene, camera)
    }
</script>

</body>
</html>