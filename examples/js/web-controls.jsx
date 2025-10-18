const { useState } = React;

function SimpleControls() {
  return (
    <div className="grid grid-cols-12 gap-6">
      <div className="col-span-12">
        <h3 className="mb-3 font-semibold text-lg">Simple Controls</h3>
      </div>
      <div className="col-span-12 md:col-span-5 lg:col-span-4">
        <div className="bg-white rounded-xl shadow p-4">
          <h5 className="mb-3">Buttons</h5>
          <button className="px-5 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 mr-2 mb-2">Long</button>
          <button className="px-5 py-3 rounded-lg text-white bg-blue-600 hover:bg-blue-700 mr-2 mb-2">Long</button>
          <button className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 mb-2">Regular</button>
          <hr className="my-4" />
          <h5 className="mt-3 mb-2">Lists</h5>
          <ul className="list-disc pl-5 mb-3">
            <li>Item1</li>
            <li>Item2</li>
            <li>Item3</li>
            <li>Item4</li>
          </ul>
          <ul className="">
            <li className="block px-4 py-2 border rounded-t-lg">Item1</li>
            <li className="block px-4 py-2 border-t-0 border">Item2</li>
            <li className="block px-4 py-2 border-t-0 border">Item3</li>
            <li className="block px-4 py-2 border-t-0 border rounded-b-lg">Item4</li>
          </ul>
        </div>
      </div>
      <div className="col-span-12 md:col-span-7 lg:col-span-8">
        <div className="bg-white rounded-xl shadow p-4">
          <code className="block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-2 text-sm">{
            `A button is created like this: \n$btn1 = new HtmlButton('Regular','','regular button','longBtn','btn btn-default');\nThe button parameters are: button label, onclick event, button title, button id ,css class\n\nLists are created with: \n$listvar = new HtmlUl('','','list-group'); // assign a new <ul> control to $listvar, and use list-group as css class\nThen use ->addElement to add <li> elements to the list, like this: $listvar->addElement(new HtmlLi('Item1','','list-group-item'));`
          }</code>
        </div>
      </div>
    </div>
  );
}

function Panel({ title, children }) {
  return (
    <div className="bg-white rounded-xl shadow">
      <div className="px-4 py-3 border-b">
        <h3 className="m-0 text-lg font-semibold">{title}</h3>
      </div>
      <div className="p-4">{children}</div>
    </div>
  );
}

function Panels() {
  const [name, setName] = useState('');
  return (
    <>
      <div className="grid grid-cols-12 gap-6 mt-6">
        <div className="col-span-12">
          <h3 className="mb-3 font-semibold text-lg">Panels</h3>
        </div>
        <div className="col-span-12 md:col-span-5 lg:col-span-4">
          <Panel title="My Panel Title">
            My Panel text content, Simple text content, but html controls can be added as well as seen below
          </Panel>
        </div>
        <div className="col-span-12 md:col-span-7 lg:col-span-8">
          <div className="bg-white rounded-xl shadow p-4">
            Panel with default style, created like this: <br />
            <code className="block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-2 text-sm">{'$panel = new HtmlPanel(\'My Panel Title\', "Simple text content, but html controls can be added as well as seen below", \'\');\nAbove we created a HtmlPanel with a given title and content'}</code>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-12 gap-6 mt-6">
        <div className="col-span-12 md:col-span-5 lg:col-span-4">
          <Panel title="Panel with text content as well as html controls">
            Complete the form below
            <form className="mt-3" onSubmit={(e)=>{e.preventDefault();}}>
              <input className="border rounded px-3 py-2 w-full" placeholder="Please enter your name" value={name} onChange={e=>setName(e.target.value)} />
              <button type="submit" className="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white mt-2">Submit</button>
            </form>
          </Panel>
        </div>
        <div className="col-span-12 md:col-span-7 lg:col-span-8">
          <div className="bg-white rounded-xl shadow p-4">
            Panel with success style, and html controls, created like this: <br />
            <code className="block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-2 text-sm">{'$panel2 = new HtmlPanel(\'Panel with text content as well as html controls\', "Complete the form below", \'\',\'panel panel-success\');\n$form = (new HtmlForm(\'form1\',\'post\'))->addElement((new HtmlInput(\'text\',\'input1\',\'\',\'\',\'form-control\'))->addProperty(\'placeholder\',\'Please enter your name\'));\n$form->addElement(new HtmlInput(\'submit\',\'submit\',\'Submit\',\'\',\'btn btn-success\'));\n$panel2->addElement($form);'}</code>
          </div>
        </div>
      </div>
    </>
  );
}

function Tables() {
  const header = ['Player', 'Games played', 'Score'];
  const rows = [
    ['John', '5', '40%'],
    ['Mike', '7', '45%'],
    ['Tello', '3', '30%']
  ];
  return (
    <div className="grid grid-cols-12 gap-6 mt-6">
      <div className="col-span-12">
        <h3 className="mb-3 font-semibold text-lg">Tables</h3>
      </div>
      <div className="col-span-12 md:col-span-5 lg:col-span-4">
        <div className="overflow-x-auto">
          <table className="min-w-full bg-white rounded shadow-sm">
            <thead className="bg-gray-100">
              <tr>
                {header.map((h,i)=> <th key={i} className="text-left px-4 py-2">{h}</th>)}
              </tr>
            </thead>
            <tbody>
              {rows.map((r, i) => (
                <tr key={i} className="border-t">
                  <td className="px-4 py-2">{r[0]}</td>
                  <td className="px-4 py-2">{r[1]}</td>
                  <td className="px-4 py-2">{r[2]}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
      <div className="col-span-12 md:col-span-7 lg:col-span-8">
        <div className="bg-white rounded-xl shadow p-4">
          HtmlTable populated from data in a csv file
          <code className="block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-2 text-sm">{'$table = new HtmlTable("100%","","","table");\n$scoredata = array_map(\'str_getcsv\', str_getcsv(file_get_contents(\'scores.txt\'),"\n"));\n$first = true; // to make the first row a header\nforeach($scoredata as $score) { ... }'}</code>
        </div>
      </div>
    </div>
  );
}

function App() {
  return (
    <div className="container mx-auto py-5">
      <div className="text-center mb-5">
        <h2 className="font-bold text-2xl md:text-3xl">PHP PROGRAMMING Controls — Web Controls (React)</h2>
        <p className="text-gray-600">Buttons, lists, panels, and tables styled with Tailwind CSS</p>
      </div>
      <SimpleControls />
      <Panels />
      <Tables />
    </div>
  );
}

const root = ReactDOM.createRoot(document.getElementById('react-root'));
root.render(<App />);
