<!DOCTYPE html>
<html><head>
    <style>
      body,html{
        background: #000;
        margin: 0;
        height: 100vh;
        font-family: courier;
      }
      #c{
        width: 100%;
        height: 100%;
        position: absolute;
        background: #000;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
      }
    </style>
  </head>
  <body>
    <canvas id="c" width="1920" height="1079" style="height: 587.812px; width: 100vw;"></canvas>
    <script>
c=document.querySelector('#c')
c.width  = 1920
c.height = 1080
x=c.getContext('2d')
S=Math.sin
C=Math.cos
Rn=Math.random
R = function(r,g,b,a) {
  a = a === undefined ? 1 : a;
  return "rgba("+(r|0)+","+(g|0)+","+(b|0)+","+a+")";
};
t=go=0
rsz=window.onresize=()=>{
  setTimeout(()=>{
    if(document.body.clientWidth > document.body.clientHeight*1.77777778){
      c.style.height = '100vh'
      setTimeout(()=>c.style.width = c.clientHeight*1.77777778+'px',0)
    }else{
      c.style.width = '100vw'
      setTimeout(()=>c.style.height = c.clientWidth/1.77777778 + 'px',0)
    }
    c.width=1920
    c.height=c.width/1.777777778
  },0)
}
rsz()

Draw=()=>{
  if(!t){
    R=(Rl,Pt,Yw,m)=>{
      M=Math
      A=M.atan2
      H=M.hypot
      X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
      Y=C(p)*d
      X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
      Z=C(p)*d
      Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
      Z=C(p)*d
      if(m){
        X+=oX
        Y+=oY
        Z+=oZ
      }
    }
    Q=()=>[c.width/2+X/Z*800,c.height/2+Y/Z*800]
    I=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0

    stroke=(scol,fcol)=>{
      if(scol){
        x.closePath()
        x.globalAlpha=.2
        x.strokeStyle=scol
        x.lineWidth=Math.min(500, 500/Z)
        x.stroke()
        x.globalAlpha=1
        x.lineWidth/=4
        x.stroke()
      }
      if(fcol){
        x.fillStyle=fcol
        x.fill()
      }
    }

    
    alpha = []
    buffer = document.createElement('canvas')
    buffer.width = 100
    buffer.height = 100
    bctx = buffer.getContext('2d')
    bctx.font = '100px courier'
    for(i=33; i<126; ++i){
      char = String.fromCharCode(i)
      bctx.fillStyle='#000'
      bctx.fillRect(0,0,buffer.width,buffer.height)
      bctx.fillStyle='#fff'
      bctx.fillText(char,0,70)
      let data = bctx.getImageData(0,0,100,100)
      let l = data.data
      ct = maxd = 0
      for(j=0; j<l.length; j+=4){
        red    = l[j+0]
        green  = l[j+1]
        blue   = l[j+2]
        a      = l[j+3]
        lum = (red + green + blue) / 3
        if(lum > 3) ct++
        if(ct>maxd)maxd=ct
      }
      alpha = [...alpha, [char, ct]]
    }
    alpha.sort((a,b)=>a[1]-b[1])
    alpha.map((v,i)=>{
      v[1]=Math.round((i+1)/alpha.length*255)
    })

    bg = document.createElement('video')
    go=false
    bg.oncanplay=()=>{
      w=bg.videoWidth
      h=bg.videoHeight
      go=true
      bg.play()
    }
    bg.muted = true
    bg.loop = true
    bg.defaultPlaybackRate=1
    bg.src = '5n9FT.mp4'
  }

  x.fillStyle='#000'
  x.fillRect(0,0,c.width,c.height)
  oX=oY=0, oZ=10
  Rl=0,Pt=0,Yw=0
  x.lineJoin=x.lineCap='round'

  if(go){
      buffer.width = (bg.width || bg.videoWidth)
      buffer.height = (bg.height || bg.videoHeight)
    let w_ = (bg.width || bg.videoWidth)
    let h_ = (bg.height || bg.videoHeight)
    bctx.drawImage(bg,buffer.width/2-w_/1.5,buffer.height/2-h_/1.5,w_*1.333,h_*1.33)
    data = bctx.getImageData(0,0,buffer.width,buffer.height)
    l = data.data
    cl = (bg.width || bg.videoWidth)/16|0, rw = cl / w * h
    sp = w/cl
    ip1=Math.max(0,Math.min(1,(S(t*2)/2)*3))
    ip2=1-ip1
    ra=c.width/buffer.width
    tsp=sp*ra
    x.font=tsp*1.1+'px courier'
    for(i=0;i<cl*rw|0;i++){
      X=(i%cl)*sp
      Y=(i/cl|0)*sp
      tx=X*ra
      ty=Y*ra//-buffer.height/2.5
      idx=((Y*sp*cl+X)|0)*4
      red    = l[idx+0]
      green  = l[idx+1]
      blue   = l[idx+2]
      a      = l[idx+3]
      let lum = (red + green + blue)/3
      x.fillStyle=`rgba(${red},${green},${blue*ip1},${1})`
      x.globalAlpha=ip1
      x.fillRect(tx,ty,tsp+2,tsp+2)
      //x.fillStyle='#fff'
      x.globalAlpha=ip2
      x.fillStyle=`rgba(${lum*1},${lum*3},${lum*2},${1})`
      a_idx = lum/256*alpha.length|0
      x.fillText(alpha[a_idx][0],tx+2,ty+tsp*.6+2,tsp,tsp)
    }
  }
  x.globalAlpha=1

  t+=1/60
  requestAnimationFrame(Draw)

}
Draw()
</script>
  

</body></html>
