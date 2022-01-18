import React from 'react';
const hostname = window.location.hostname;

export default class App extends React.Component{

  constructor(props){
    super(props);
    this.state = {
      tag:''
    }
    this.init.bind(this);
    this.init();
  }

  init = () => {
    this.updateLinks();
  }

  updateLinks = () => {
    fetch(`http://${hostname}:8000/api/getdata`)
    .then(response => response.json())
    .then((data) => {
      document.getElementById('links').innerHTML = '';
      for(let i = 0; i < data.length; i++)
      {
        if(this.state.tag != '' || this.state.tag != null){
          if(data[i].tags.indexOf(this.state.tag) != -1)
          {
            let template = `<div class='page'><h2 class='name' href='${data[i].url}'>${data[i].name}</h2><p class='comments'>${data[i].comments}</p><p class='tags'>${data[i].tags}</p></div>`
            document.getElementById('links').innerHTML += template;
          }
        }
        else{
          let template = `<div class='page'><h2 class='name' href='${data[i].url}'>${data[i].name}</h2><p class='comments'>${data[i].comments}</p><p class='tags'>${data[i].tags}</p></div>`
          document.getElementById('links').innerHTML += template;
        }
      }
    })
  }

  render(){
    return(
      <div className="pageContainer">
        <button onClick={()=>{this.state.tag='laravel'; this.updateLinks()}}>Laravel</button>
        <button onClick={()=>{this.state.tag='vue'; this.updateLinks()}}>Vue</button>
        <button onClick={()=>{this.state.tag='php'; this.updateLinks()}}>Php</button>
        <button onClick={()=>{this.state.tag='api'; this.updateLinks()}}>Api</button>
        <div className="links" id='links'>

        </div>
      </div>
    )
  }
}
