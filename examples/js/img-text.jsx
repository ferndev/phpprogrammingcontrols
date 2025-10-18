const App = () => {
  return (
    <div className="grid grid-cols-12 gap-6">
      <div className="col-span-12 text-center mb-6">
        <h2 className="font-bold text-2xl md:text-3xl text-gray-800">PHP PROGRAMMING Controls — Image + Text Area (React)</h2>
        <p className="text-gray-600">A simple image and textarea demo</p>
      </div>
      <div className="col-span-12 md:col-span-5 lg:col-span-4">
        <img src="img/buddy-face-small.png" alt="The nicest friend :)" className="rounded shadow-md mb-3 max-w-full" />
        <textarea className="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" rows={5} placeholder="Write about your dog" />
      </div>
      <div className="col-span-12 md:col-span-7 lg:col-span-8">
        <div className="bg-white rounded-xl shadow p-4">
          <div>HtmlImg with a Tailwind-styled HtmlTextArea</div>
          <code className="block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-3 text-sm">
            {`$img = new HtmlImg('img/buddy-face-small.png','The nicest friend :)','', 'rounded shadow-md mb-3 max-w-full');\n`}
            {`$ta = new HtmlTextArea('about','5','80');\n`}
            {`$ta->addProperty('class','w-full px-3 py-2 border border-gray-300 rounded')->addProperty('placeholder','Write about your dog');`}
          </code>
        </div>
      </div>
    </div>
  );
};

const root = ReactDOM.createRoot(document.getElementById('react-img-text'));
root.render(<App />);
