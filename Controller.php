//add image to the storage disk.
public function uploadImageViaAjax(Request $request)
{
$name = [];
$original_name = [];
foreach ($request->file('file') as $key => $value) {
$image = uniqid() . time() . '.' . $value->getClientOriginalExtension();
$destinationPath = public_path().'/images/';
$value->move($destinationPath, $image);
$name[] = $image;
$original_name[] = $value->getClientOriginalName();
}

return response()->json([
'name' => $name,
'original_name' => $original_name
]);
}

//add form data to database
public function store(Request $request)
{
$messages = array(
'images.required' => 'Image is Required.'
);
$this->validate($request, array(
'images' => 'required|array|min:1',
),$messages);

foreach ($request->images as $image) {
Image::create([
'name' => $image,
'created_by' => Auth::id()
]);
}

return redirect()
->route('home')
->with('success', 'Images Added Successfully');
}