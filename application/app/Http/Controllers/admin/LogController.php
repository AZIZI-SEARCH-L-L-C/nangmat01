<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;
use Crypt, Log, Input;

class LogController extends Controller
{
    protected $request;
	
	public function get(){
		$this->request = app('request');
		$allFiles = LaravelLogViewer::getFiles(true);
		sort($allFiles);
		
		// dd($files);
		if(isset($allFiles[0])){
			$startDate = $allFiles[0];
		}else{
			$startDate = null;
		}
		// return day logs
		if ($this->request->input('day')) {
            $current_day = $this->request->input('day');
			$files = glob(storage_path() . '/logs/*'. $current_day .'.log');
        }else{
			$current_day = date('Y-m-d');
			$files = glob(storage_path() . '/logs/*'. $current_day .'.log');
		}
		
		$today = false;
		if(date('Y-m-d') == $this->request->input('day')) $today = true;
		
		$data = [
			'logs'         => [],
			'allFiles'     => $allFiles,
			'files'        => $files,
			'current_day'  => $current_day,
			'startDate'    => $startDate,
			'today'        => $today
		];
		foreach($files as $file){
			LaravelLogViewer::setFile($file);
			$data['logs'] = array_merge($data['logs'], LaravelLogViewer::all());
		}
		
        if ($this->request->input('download')) {
			$content = '';
			$sperator = ',';
			$i = 0;
			foreach($data['logs'] as $logLines){
				if($i == 0) {
					$content .= 'full_date'.$sperator.'context'.$sperator.'level'.$sperator.'text'.$sperator.'file'.$sperator.'stack';
				}else{
					$content .= "\n".$logLines['full_date'].$sperator.$logLines['context'].$sperator.$logLines['level'].$sperator.str_replace(',', ';', $logLines['text']).$sperator.$logLines['in_file'].$sperator.str_replace(',', ';', $logLines['stack']);
				}
				$i++;
			}
			
			$headers = [
				'Content-type'        => 'text/csv',
				'Content-Disposition' => 'attachment; filename="'. $current_day .'-log.csv"',
			];

			return response()->make($content, 200, $headers);
        } elseif ($this->request->has('clear')) {
			foreach($files as $file){
				app('files')->delete(LaravelLogViewer::pathToLogFile($file));
			}
			session()->flash('messageType', 'success');
			session()->flash('message', 'Log cleared for: '. $current_day);
			return redirect()->route('admin.log');
        } elseif ($this->request->has('clearAll')) {
            foreach($allFiles as $day){
				$files = glob(storage_path() . '/logs/*'. $day .'.log');
				foreach($files as $Cday){
					app('files')->delete(LaravelLogViewer::pathToLogFile($Cday));
				}
            }
			session()->flash('messageType', 'success');
			session()->flash('message', 'All logs cleared.');
			return redirect()->route('admin.log');
        }
        
		// preg_match("/\d{4}-\d{2}-\d{2}/", $input_string, $match);
		// dd($data);
		
		return view('admin.log', array_merge($this->CommonData(), $data));
	}
	
	public function post(){
		if(Input::has('submitLogSettings')){
			$allowed_levels = [
				'debug',
				'info',
				'notice',
				'warning',
				'error',
				'critical',
				'alert',
				'emergency',
			];
			if(in_array(Input::get('logLevel'), $allowed_levels)){
				$this->putAppEnv('APP_LOG_LEVEL', Input::get('logLevel'));
			}
			if(is_numeric(Input::get('LogMaxDays'))){
				$this->putAppEnv('APP_LOG_MAX_FILES', Input::get('LogMaxDays'));
			}
		}
		session()->flash('messageType', 'success');
		session()->flash('message', 'All changes have been changed.');
		return redirect()->route('admin.log');
	}
	
	private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }
        return app('redirect')->to($to);
    }
    private function download($data)
    {
        if (function_exists('response')) {
            return response()->download($data);
        }
        // For laravel 4.2
        return app('\Illuminate\Support\Facades\Response')->download($data);
    }
}
