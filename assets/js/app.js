//import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
//import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

//import ItemCard from './Components/ItemCard';

class App extends React.Component {
  constructor() {
    super();

    this.state = {
      entries: []
    };
  }

  componentDidMount() {
   /** fetch('/data')
      .then(response => response.json())
      .then(entries => {
        this.setState({
          entries
        });
      });*/
  }

  render() {
    return (
           "Some String"
            
    );
  }
}

ReactDOM.render(<App />, document.getElementById('reactRoot'));
